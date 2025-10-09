<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $token;
    public $email;

    public function __construct(string $token, string $email)
    {
        $this->token = $token;
        $this->email = $email;
    }

    public function build()
    {
        $resetUrl = url("/guest/reset-password?token={$this->token}&email=" . urlencode($this->email));

        return $this->subject('Reset Your Password')
            ->view('emails.reset-link') // simple message with link only
            ->with(['resetUrl' => $resetUrl]);
    }
}
