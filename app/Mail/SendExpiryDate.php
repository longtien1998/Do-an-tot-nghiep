<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendExpiryDate extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $date;
    public $email;
    public $users_type;
    public $name;
    public function __construct($date, $email, $users_type, $name)
    {
        $this->date = $date;
        $this->email = $email;
        $this->users_type = $users_type;
        $this->name = $name;

    }

    /**
     * Get the message envelope.
     */

    public function build() {
        return $this->subject('Thông báo tài khoản hết hạn')
                    ->view('admin.mail.mailCheckUser')
                    ->with([
                        'date' => $this->date,
                        'email' => $this->email,
                        'users_type' => $this->users_type,
                        'name' => $this->name,
                     ]);
    }

}
