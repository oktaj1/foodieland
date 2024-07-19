@component('mail::message')
<style>
    .header { font-size: 24px; font-weight: bold; color: #3490dc; text-align: center; margin-bottom: 20px; }
    .content { font-size: 16px; color: #333; text-align: center; margin-bottom: 20px; }
    .footer { font-size: 14px; color: #777; text-align: center; margin-top: 20px; }
    .button { background-color: #3490dc; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 12px; }
    .logo { display: block; margin: 0 auto 20px; max-width: 150px; height: auto; }
</style>

<div class="header">Password Reset Request</div>

<div class="content">
    You are receiving this email because we received a password reset request for your account. Click the button below to reset your password:
</div>

@component('mail::button', ['url' => $resetUrl, 'color' => 'primary'])
Reset Password
@endcomponent

<div class="content">
    This password reset link will expire in 60 minutes.<br>
    If you did not request a password reset, no further action is required.
</div>

<img src="{{ config('app.url') }}/images/logo.png" alt="Foodieland Logo" class="logo">

<div class="footer">
    If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<br>
    {{ $resetUrl }}
</div>
@endcomponent
        