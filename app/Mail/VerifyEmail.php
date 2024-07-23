<?php

namespace App\Mail;

use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $resetUrl;

    public function __construct($user)
    {
        $this->user = $user;
        $this->resetUrl = $this->generateResetUrl($user);
    }

    public function build()
    {
        return $this->markdown('mail.reset-password')
                    ->subject('Reset Your Password - Foodieland')
                    ->with([
                        'user' => $this->user,
                        'resetUrl' => $this->resetUrl
                    ]);
    }

    protected function generateResetUrl($user)
    {
        $token = Str::random(60);
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => $token,
            'created_at' => now()
        ]);

        return URL::temporarySignedRoute(
            'password.reset',
            now()->addMinutes(60),
            ['token' => $token, 'email' => $user->email]
        );
    }
}