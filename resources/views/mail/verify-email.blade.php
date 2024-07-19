@component('mail::message')
<style>
    .header { font-size: 24px; font-weight: bold; color: #4CAF50; text-align: center; margin-bottom: 20px; }
    .content { font-size: 16px; color: #333; text-align: center; margin-bottom: 20px; }
    .footer { font-size: 14px; color: #777; text-align: center; margin-top: 20px; }
    .button { background-color: #4CAF50; border: none; color: white; padding: 10px 20px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer; border-radius: 12px; }
    .logo { display: block; margin: 0 auto 20px; max-width: 500px; height: auto; }
</style>

<div class="header">Hello,</div>
<div class="content">
    Please confirm your email by clicking the button below.
</div>

@component('mail::button', ['url' => $verificationUrl, 'color' => 'success'])
Verify Email Address
@endcomponent

<img src="{{ asset('logo.png') }}" alt="Foodieland Logo" class="logo">

<div class="footer">
    Thank you!<br>
    Foodieland
</div>
@endcomponent

