<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendRegisterMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $email;
    public $date;
    /**
     * Create a new message instance.
     */
    public function __construct($name, $email, $date)
    {
        $this->name = $name;
        $this->email = $email;
        $this->date = $date;
    }

    /**
     * Get the message envelope.
     */
    public function build() {
        return $this->subject('Đăng ký tài khoản tại SOUNDWAVE thành công')
                    ->view('admin.mail.mallRegister')
                    ->with([
                        'name' => $this->name,
                        'email' => $this->email,
                        'date' => $this->date,
                     ]);
    }

}
