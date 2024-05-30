<!DOCTYPE html>
<html>
<head>
    
    <title>Reset Password</title>
</head>
<body>
    <form action="{{ url('/reset-password') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="email" name="email" placeholder="Enter your email" required>
        <input type="password" name="password" placeholder="New password" required>
        <input type="password" name="password_confirmation" placeholder="Confirm new password" required>
        <button type="submit">Reset Password</button>
    </form>
</body>
</html>