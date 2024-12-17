<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendContactMail extends Mailable
{
    use Queueable, SerializesModels;
    public $topic;
    public $email;
    public $username;
    /**
     * Create a new message instance.
     */
    public function __construct($topic, $email, $username)
    {
        $this->topic = $topic;
        $this->email = $email;
        $this->username = $username;
    }

    /**
     * Get the message envelope.
     */
    public function build() {
        return $this->subject('Cảm ơn bạn đã liên hệ với chúng tôi!')
                    ->view('admin.mail.mailContact')
                    ->with([
                        'topic' => $this->topic,
                        'email' => $this->email,
                        'username' => $this->username,
                    ]);
    }
}
