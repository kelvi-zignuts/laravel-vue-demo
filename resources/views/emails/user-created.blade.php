<!DOCTYPE html>
<html>
<head>
    <title>Welcome {{ $user->name }}</title>
</head>
<body>
    <p>Thank you for registering with us!</p>
    <p>Your email: {{ $user->email }}</p>
    <p>
        <a href="{{ url('/reset-password?token=' . $resetToken) }}" 
           style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none;">
            Reset Password
        </a>
    </p>
</body>
</html>