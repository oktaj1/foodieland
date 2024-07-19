<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EmailInfoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Your Account Information')
                    ->html("
                        <p>Hello {$this->user->name},</p>
                        <p>Your registered email address is: {$this->user->email}</p>
                        <p>If you did not request this information, please contact our support team.</p>
                        <p>Thanks,<br>{{ config('app.name') }}</p>
                    ");
    }
}

