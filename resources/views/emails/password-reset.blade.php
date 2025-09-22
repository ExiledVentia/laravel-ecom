<!DOCTYPE html>
<html>

<head>
    <title>Password Reset</title>
</head>

<body>
    <h2>Reset Your Password</h2>
    <p>Please click the button below to reset your password:</p>

    <a href="{{ route('password.reset', ['token' => $token]) }}"
        style="background-color: #4CAF50; color: white; padding: 14px 25px; text-align: center; text-decoration: none; display: inline-block;">
        Reset Password
    </a>

    <p>This password reset link will expire in
        {{ config('auth.passwords.' . config('auth.defaults.passwords') . '.expire') }} minutes.</p>
</body>

</html>
