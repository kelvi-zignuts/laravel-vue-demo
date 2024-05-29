<!DOCTYPE html>
<html>
<head>
    <title>Welcome {{ $user->name }}</title>
</head>
<body>
    <p>Thank you for registering with us!</p>
    <p>Your email: {{ $user->email }}</p>
</body>
</html>
