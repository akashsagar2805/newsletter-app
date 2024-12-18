<?php

namespace App\Mail;

use App\Models\Newsletter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public $newsletter;

    /**
     * Create a new message instance.
     */
    public function __construct(Newsletter $newsletter)
    {
        $this->newsletter = $newsletter;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject($this->newsletter->title)
            ->view('emails.newsletter') // The Blade view for the email template
            ->with([
                'content' => $this->newsletter->content,
            ]);
    }
}
