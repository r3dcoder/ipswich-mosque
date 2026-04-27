<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\MosqueSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Show the contact form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $mapSettings = MosqueSetting::getSettings();
        return view('contact', compact('mapSettings'));
    }

    /**
     * Store a newly created contact in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
            'phone' => 'nullable|string|max:20',
            'contact_method' => 'required|in:email,phone,any',
        ], [
            'name.required' => 'Please enter your name.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'subject.required' => 'Please enter a subject.',
            'message.required' => 'Please enter your message.',
            'message.min' => 'Your message must be at least 10 characters long.',
            'contact_method.required' => 'Please select a preferred contact method.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the contact
        $contact = Contact::create($request->all());

        // Send notification emails
        try {
            $this->sendNotificationEmail($contact);
            $this->sendUserAcknowledgmentEmail($contact);
        } catch (\Exception $e) {
            // Log the error but don't fail the request
            \Log::error('Failed to send contact notification email: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Send notification email to admin for new contact.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    private function sendNotificationEmail(Contact $contact)
    {
        $adminEmail = config('mail.from.address') ?: env('MAIL_FROM_ADDRESS', 'admin@ipswichmosque.org');
        $adminName = config('mail.from.name') ?: env('MAIL_FROM_NAME', 'Ipswich Mosque');

        $subject = "New Contact Form Submission: {$contact->subject}";
        
        $message = view('emails.contact_notification', compact('contact'))->render();

        // Use Laravel's Mail facade for proper email sending
        // Set the user's email as the "From" address so admin can easily reply
        Mail::send([], [], function ($mail) use ($contact, $adminEmail, $adminName, $subject) {
            $mail->to($adminEmail)
                 ->from($contact->email, $contact->name)
                 ->replyTo($contact->email, $contact->name)
                 ->subject($subject)
                 ->html(view('emails.contact_notification', compact('contact'))->render());
        });
    }

    /**
     * Send acknowledgment email to user who submitted the form.
     *
     * @param  \App\Models\Contact  $contact
     * @return void
     */
    private function sendUserAcknowledgmentEmail(Contact $contact)
    {
        $adminEmail = config('mail.from.address') ?: env('MAIL_FROM_ADDRESS', 'admin@ipswichmosque.org');
        $adminName = config('mail.from.name') ?: env('MAIL_FROM_NAME', 'Ipswich Mosque');

        $subject = "Thank You for Contacting Ipswich Mosque";

        // Use Laravel's Mail facade for proper email sending
        Mail::send([], [], function ($mail) use ($contact, $adminEmail, $adminName, $subject) {
            $mail->to($contact->email)
                 ->from($adminEmail, $adminName)
                 ->subject($subject)
                 ->html(view('emails.user_acknowledgment', compact('contact'))->render());
        });
    }
}