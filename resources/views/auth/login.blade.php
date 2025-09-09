<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Looooooooooooooooooooogin</title>
</head>

<body>
    <h1>stecu stecu</h1>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div>
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div>
            <label>Password</label>
            <input type="password" name="password" required>
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label><input type="checkbox" name="remember"> Remember Me</label>
        </div>
        <br>
        <button type="submit">Login</button>
    </form>

    <p>
        <a href="{{ route('register') }}">Don't have an account? Register</a>
    </p>
    <p>
        <a href="{{ url('/auth/redirect/google') }}" class="btn btn-danger">Login with Google</a>
    </p>

</body>

</html>
