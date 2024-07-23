@component('mail::message')
<style>
    .header { font-size: 28px; font-weight: bold; color: #2c3e50; text-align: center; margin-bottom: 30px; text-transform: uppercase; letter-spacing: 2px; }
    .content { font-size: 18px; color: #34495e; text-align: center; margin-bottom: 30px; line-height: 1.6; }
    .footer { font-size: 14px; color: #7f8c8d; text-align: center; margin-top: 30px; }
    .button { background-color: #3498db; border: none; color: white; padding: 12px 24px; text-align: center; text-decoration: none; display: inline-block; font-size: 18px; margin: 4px 2px; cursor: pointer; border-radius: 50px; transition: background-color 0.3s ease; }
    .button:hover { background-color: #2980b9; }
    .logo { display: block; margin: 0 auto 30px; max-width: 180px; height: auto; }
    .divider { border-top: 2px solid #ecf0f1; margin: 30px 0; }
</style>

<img src="{{ config('app.url') }}/images/logo.png" alt="Foodieland Logo" class="logo">

<div class="header">Reset Your Password</div>

<div class="content">
    Hello there!<br><br>
    We received a request to reset your password. Don't worry, we've got you covered. Click the button below to securely reset your password:
</div>

@component('mail::button', ['url' => $resetUrl, 'color' => 'primary'])
Reset Password
@endcomponent

<div class="content">
    This password reset link is valid for the next 60 minutes.<br>
    If you didn't request this reset, please ignore this email or contact our support team if you have any concerns.
</div>

<div class="divider"></div>

<div class="footer">
    If the button above doesn't work, copy and paste this URL into your browser:<br>
    <a href="{{ $resetUrl }}">{{ $resetUrl }}</a><br><br>
    © {{ date('Y') }} Foodieland. All rights reserved.
</div>
@endcomponent