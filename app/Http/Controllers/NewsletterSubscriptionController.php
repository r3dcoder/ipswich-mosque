<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use App\Models\Notice;
use App\Mail\NewNoticeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class NewsletterSubscriptionController extends Controller
{
    /**
     * Display the notice board page.
     */
    public function notices()
    {
        $notices = Notice::active()
            ->orderBy('is_pinned', 'desc')
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        $categories = Notice::CATEGORIES;

        return view('notices', compact('notices', 'categories'));
    }

    /**
     * Display a single notice.
     */
    public function showNotice(Notice $notice)
    {
        if (!$notice->is_active || ($notice->published_at && $notice->published_at->isFuture())) {
            abort(404);
        }

        $notice->incrementViewCount();

        return view('notice-single', compact('notice'));
    }

    /**
     * Display the newsletter archive page.
     */
    public function newsletters()
    {
        $newsletters = \App\Models\Newsletter::sent()
            ->orderBy('sent_at', 'desc')
            ->paginate(10);

        return view('newsletters', compact('newsletters'));
    }

    /**
     * Display a single newsletter.
     */
    public function showNewsletter(\App\Models\Newsletter $newsletter)
    {
        if (!$newsletter->sent_at) {
            abort(404);
        }

        return view('newsletter-single', compact('newsletter'));
    }

    /**
     * Subscribe to the newsletter.
     */
    public function subscribe(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'name' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        NewsletterSubscriber::create([
            'email' => $request->email,
            'name' => $request->name,
            'is_subscribed' => true,
        ]);

        return redirect()->back()
            ->with('success', 'Thank you for subscribing to our newsletter!');
    }

    /**
     * Unsubscribe from the newsletter.
     */
    public function unsubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where('subscription_token', $token)->firstOrFail();

        $subscriber->unsubscribe();

        return view('newsletter-unsubscribed', compact('subscriber'));
    }

    /**
     * Resubscribe to the newsletter.
     */
    public function resubscribe($token)
    {
        $subscriber = NewsletterSubscriber::where('subscription_token', $token)->firstOrFail();

        $subscriber->resubscribe();

        return redirect()->back()
            ->with('success', 'You have been resubscribed to our newsletter!');
    }
}