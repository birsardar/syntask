<!-- resources/views/auth/forgot-password.blade.php -->
@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-container">
    <div class="text-center mb-4">
        <img src="{{ asset('images/syntask-logo.png') }}" alt="SynTask Logo" height="60">
        <h1 class="h3 mt-3">Reset Password</h1>
        <p class="text-muted">Enter your email to receive a password reset link</p>
    </div>

    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-4">
            <label for="email" class="form-label">Email Address</label>
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary">Send Reset Link</button>
        </div>

        <div class="text-center">
            <p><a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a></p>
        </div>
    </form>
</div>
@endsection
