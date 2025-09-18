@extends('layouts.master')

@section('content')
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
        <a href="{{ route('password.request') }}">Forgot Password?</a>
    </p>
    <p>
        <a href="{{ route('register') }}">Don't have an account? Register</a>
    </p>
    <p>
        <a href="{{ url('/auth/redirect/google') }}" class="btn btn-danger">Login with Google</a>
    </p>
@endsection
