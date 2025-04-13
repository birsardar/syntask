<!-- resources/views/auth/reset-password.blade.php -->
@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="auth-container">
    <div class="text-center mb-4">
        <img src="{{ asset('images/syntask-logo.png') }}" alt="SynTask Logo" height="60">
        <h1 class="h3 mt-3">Set New Password</h1>
        <p class="text-muted">Create a new password for your account</p>
    </div>

    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
            <div class="password-strength-container mt-1">
                <div class="password-strength bg-danger" id="passwordStrength"></div>
            </div>
            <small class="text-muted">Use at least 8 characters with a mix of letters, numbers & symbols</small>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="form-label">Confirm New Password</label>
            <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
        </div>

        <div class="d-grid gap-2 mb-3">
            <button type="submit" class="btn btn-primary">Reset Password</button>
        </div>

        <div class="text-center">
            <p><a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a></p>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('password').addEventListener('input', function() {
        const password = this.value;
        const strength = document.getElementById('passwordStrength');
        let width = 0;
        let backgroundColor = 'bg-danger';

        if (password.length >= 8) {
            width += 25;
        }

        if (password.match(/[A-Z]/)) {
            width += 25;
        }

        if (password.match(/[0-9]/)) {
            width += 25;
        }

        if (password.match(/[^A-Za-z0-9]/)) {
            width += 25;
        }

        if (width >= 75) {
            backgroundColor = 'bg-success';
        } else if (width >= 50) {
            backgroundColor = 'bg-warning';
        }

        strength.style.width = width + '%';
        strength.className = 'password-strength ' + backgroundColor;
    });
</script>
@endsection

