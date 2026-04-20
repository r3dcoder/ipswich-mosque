<?php

namespace App\Mail;

use App\Models\Notice;
use App\Models\NewsletterSubscriber;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewNoticeNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $notice;
    public $subscriber;

    public function __construct(Notice $notice, NewsletterSubscriber $subscriber)
    {
        $this->notice = $notice;
        $this->subscriber = $subscriber;
    }

    public function build()
    {
        return $this->subject('New Notice from Ipswich Mosque: ' . $this->notice->title)
                    ->view('emails.new-notice-notification')
                    ->with([
                        'notice' => $this->notice,
                        'subscriber' => $this->subscriber,
                        'unsubscribeUrl' => url('/newsletter/unsubscribe/' . $this->subscriber->subscription_token),
                    ]);
    }
}