<!-- resources/views/mail/reset_password.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
            text-align: center;
        }
        .button {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 20px;
            background-color: #007bff;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .header {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333333;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">Password Reset Request</div>
        <p>Hello {{ $user->name }},</p>
        <p>You are receiving this email because we received a password reset request for your account.</p>
        <p>Please click the button below to reset your password:</p>
        <a href="{{ $resetUrl }}" class="button">Reset Password</a>
        <p>If you did not request a password reset, no further action is required.</p>
        <div class="footer">
            <p>Thank you!</p>
            <p>&copy; {{ date('Y') }} FOODIELAND. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
