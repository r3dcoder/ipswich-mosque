<?php

namespace App\Console\Commands;

use App\Models\Donation;
use App\Services\StripeConfig;
use Illuminate\Console\Command;
use Stripe\PaymentIntent;
use Stripe\Subscription;

class SyncDonationStatuses extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'donations:sync-statuses {--limit=50 : Maximum number of donations to sync}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync donation statuses from Stripe';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Uses the admin-managed keys (with .env fallback) instead of reading
        // STRIPE_SECRET directly, so scheduled syncs keep working when keys are stored
        // in the database. Fails gracefully rather than calling Stripe with no key.
        try {
            StripeConfig::configure();
        } catch (\Throwable $e) {
            $this->error('Stripe is not configured: ' . $e->getMessage());

            $unreadable = StripeConfig::unreadableFields();

            if ($unreadable !== []) {
                $this->line('');
                $this->warn('These stored values are encrypted with a previous APP_KEY and cannot be read:');

                foreach ($unreadable as $field) {
                    $this->line("  - {$field}");
                }

                $this->line('');
                $this->info('Re-enter them in Admin → Stripe Settings, or restore the previous APP_KEY in .env.');
                $this->info('Run "php artisan stripe:check-encryption --clear" to remove the unreadable values.');
            }

            return Command::FAILURE;
        }

        $limit = $this->option('limit');
        $donations = Donation::where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();

        $this->info("Found {$donations->count()} pending donations to check.");

        $updated = 0;
        $bar = $this->output->createProgressBar($donations->count());
        $bar->start();

        foreach ($donations as $donation) {
            try {
                if ($donation->stripe_subscription_id) {
                    // Check subscription status
                    $subscription = Subscription::retrieve($donation->stripe_subscription_id);
                    $newStatus = $this->mapSubscriptionStatus($subscription->status);

                    if ($donation->status !== $newStatus) {
                        $donation->status = $newStatus;
                        $donation->save();
                        $this->line("\nUpdated donation #{$donation->id}: {$donation->status}");
                        $updated++;
                    }
                } elseif ($donation->stripe_payment_intent_id) {
                    // Check payment intent status
                    $paymentIntent = PaymentIntent::retrieve($donation->stripe_payment_intent_id);
                    $newStatus = $this->mapPaymentIntentStatus($paymentIntent->status);

                    if ($donation->status !== $newStatus) {
                        $donation->status = $newStatus;
                        $donation->save();
                        $this->line("\nUpdated donation #{$donation->id}: {$donation->status}");
                        $updated++;
                    }
                }
            } catch (\Exception $e) {
                $this->error("\nError syncing donation #{$donation->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info("Sync completed. Updated {$updated} donations.");

        return Command::SUCCESS;
    }

    /**
     * Map Stripe subscription status to donation status
     */
    private function mapSubscriptionStatus(string $stripeStatus): string
    {
        $statusMap = [
            'active' => 'completed',
            'incomplete' => 'pending',
            'incomplete_expired' => 'failed',
            'past_due' => 'pending',
            'unpaid' => 'pending',
            'canceled' => 'cancelled',
            'trialing' => 'completed',
        ];

        return $statusMap[$stripeStatus] ?? 'pending';
    }

    /**
     * Map Stripe payment intent status to donation status
     */
    private function mapPaymentIntentStatus(string $stripeStatus): string
    {
        $statusMap = [
            'succeeded' => 'completed',
            'requires_payment_method' => 'pending',
            'requires_confirmation' => 'pending',
            'requires_action' => 'pending',
            'processing' => 'pending',
            'canceled' => 'failed',
            'requires_capture' => 'pending',
        ];

        return $statusMap[$stripeStatus] ?? 'pending';
    }
}