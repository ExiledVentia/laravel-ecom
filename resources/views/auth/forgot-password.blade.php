@extends('layouts.master')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <label for="email">E-Mail Address</label>
        <input id="email" type="email" name="email" :value="old('email')" required autofocus>
        @error('email')
            <span class="text-danger">{{ $message }}</span>
        @enderror
        <button type="submit">Email Password Reset Link</button>
    </form>
@endsection
