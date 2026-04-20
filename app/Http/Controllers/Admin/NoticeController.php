<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\NewsletterSubscriber;
use App\Mail\NewNoticeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    /**
     * Display a listing of the notices.
     */
    public function index(Request $request)
    {
        $query = Notice::query()->orderBy('is_pinned', 'desc')->orderBy('created_at', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->search}%")
                    ->orWhere('content', 'like', "%{$request->search}%");
            });
        }

        $notices = $query->paginate(15);

        return view('admin.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new notice.
     */
    public function create()
    {
        $categories = Notice::CATEGORIES;
        return view('admin.notices.create', compact('categories'));
    }

    /**
     * Store a newly created notice in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'summary' => 'nullable|string|max:500',
            'category' => 'required|in:' . implode(',', array_keys(Notice::CATEGORIES)),
            'is_active' => 'boolean',
            'is_pinned' => 'boolean',
            'send_email_notification' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = array_merge($validated, [
            'is_active' => $request->has('is_active'),
            'is_pinned' => $request->has('is_pinned'),
            'send_email_notification' => $request->has('send_email_notification'),
            'published_at' => $request->filled('published_at') ? $request->published_at : now(),
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('notices', 'public');
        }

        $notice = Notice::create($data);

        // Send email notification if requested
        if ($request->has('send_email_notification')) {
            $this->sendNoticeEmail($notice);
        }

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice created successfully!');
    }

    /**
     * Display the specified notice.
     */
    public function show(Notice $notice)
    {
        $notice->incrementViewCount();
        return view('admin.notices.show', compact('notice'));
    }

    /**
     * Show the form for editing the specified notice.
     */
    public function edit(Notice $notice)
    {
        $categories = Notice::CATEGORIES;
        return view('admin.notices.edit', compact('notice', 'categories'));
    }

    /**
     * Update the specified notice in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'summary' => 'nullable|string|max:500',
            'category' => 'required|in:' . implode(',', array_keys(Notice::CATEGORIES)),
            'is_active' => 'boolean',
            'is_pinned' => 'boolean',
            'send_email_notification' => 'boolean',
            'published_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:published_at',
            'image' => 'nullable|image|max:2048',
        ]);

        $data = array_merge($validated, [
            'is_active' => $request->has('is_active'),
            'is_pinned' => $request->has('is_pinned'),
            'send_email_notification' => $request->has('send_email_notification'),
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($notice->image_path) {
                Storage::disk('public')->delete($notice->image_path);
            }
            $data['image_path'] = $request->file('image')->store('notices', 'public');
        }

        $notice->update($data);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice updated successfully!');
    }

    /**
     * Remove the specified notice from storage.
     */
    public function destroy(Notice $notice)
    {
        if ($notice->image_path) {
            Storage::disk('public')->delete($notice->image_path);
        }

        $notice->delete();

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice deleted successfully!');
    }

    /**
     * Toggle the pinned status of a notice.
     */
    public function togglePin(Notice $notice)
    {
        $notice->update(['is_pinned' => !$notice->is_pinned]);

        return redirect()->back()
            ->with('success', 'Notice pinned status updated!');
    }

    /**
     * Send email notification about new notice to subscribers.
     */
    private function sendNoticeEmail(Notice $notice)
    {
        $subscribers = NewsletterSubscriber::active()->get();

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewNoticeNotification($notice, $subscriber));
            } catch (\Exception $e) {
                // Log error but continue sending to other subscribers
                \Log::error('Failed to send notice email to ' . $subscriber->email . ': ' . $e->getMessage());
            }
        }
    }
}