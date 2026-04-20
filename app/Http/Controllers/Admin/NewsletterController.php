<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use App\Models\NewsletterSubscriber;
use App\Models\Notice;
use App\Mail\NewsletterEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    /**
     * Display a listing of newsletters and subscribers.
     */
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query()->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('email', 'like', "%{$request->search}%")
                    ->orWhere('name', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_subscribed', $request->status === 'active');
        }

        $subscribers = $query->paginate(20);
        $subscribersCount = NewsletterSubscriber::count();
        $lastExport = 'Never';

        // Get sent newsletters
        $newsletters = Newsletter::orderBy('sent_at', 'desc')->limit(10)->get();

        return view('admin.newsletter.index', compact('subscribers', 'subscribersCount', 'lastExport', 'newsletters'));
    }

    /**
     * Show the form for sending a newsletter.
     */
    public function create()
    {
        $recentNotices = Notice::active()
            ->orderBy('published_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.newsletter.create', compact('recentNotices'));
    }

    /**
     * Send a newsletter to all subscribers.
     */
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'notice_id' => 'nullable|exists:notices,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $subscribers = NewsletterSubscriber::where('is_subscribed', true)->get();

        if ($subscribers->isEmpty()) {
            return redirect()->back()
                ->with('error', 'No active subscribers to send newsletter to.');
        }

        $notice = $request->filled('notice_id') ? Notice::find($request->notice_id) : null;

        $sentCount = 0;
        $failedCount = 0;

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(
                    new NewsletterEmail($request->subject, $request->content, $subscriber, $notice)
                );
                $sentCount++;
            } catch (\Exception $e) {
                $failedCount++;
                \Log::error('Failed to send newsletter to ' . $subscriber->email . ': ' . $e->getMessage());
            }
        }

        // Store the newsletter in database
        Newsletter::create([
            'title' => $request->subject,
            'content' => $request->content,
            'subject' => $request->subject,
            'sent_count' => $sentCount,
            'sent_at' => now(),
        ]);

        return redirect()->route('admin.newsletter.index')
            ->with('success', "Newsletter sent! {$sentCount} delivered, {$failedCount} failed.");
    }

    /**
     * Export subscribers as CSV.
     */
    public function export()
    {
        $subscribers = NewsletterSubscriber::active()->get();

        $csv = "Name,Email,Subscribed At\n";

        foreach ($subscribers as $subscriber) {
            $csv .= '"' . $subscriber->name . '","' . $subscriber->email . '","' . $subscriber->created_at->format('Y-m-d H:i:s') . "\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="newsletter-subscribers.csv"',
        ]);
    }

    /**
     * Remove the specified subscriber.
     */
    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();

        return redirect()->back()
            ->with('success', 'Subscriber removed successfully!');
    }
}