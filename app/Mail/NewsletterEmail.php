<?php

namespace App\Mail;

use App\Models\NewsletterSubscriber;
use App\Models\Notice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewsletterEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public $content;
    public $subscriber;
    public $notice;

    public function __construct($subject, $content, NewsletterSubscriber $subscriber, ?Notice $notice = null)
    {
        $this->subject = $subject;
        $this->content = $content;
        $this->subscriber = $subscriber;
        $this->notice = $notice;
    }

    public function build()
    {
        return $this->subject($this->subject)
                    ->view('emails.newsletter')
                    ->with([
                        'subject' => $this->subject,
                        'content' => $this->content,
                        'subscriber' => $this->subscriber,
                        'notice' => $this->notice,
                        'unsubscribeUrl' => url('/newsletter/unsubscribe/' . $this->subscriber->subscription_token),
                    ]);
    }
}