<!-- resources/views/auth/register.blade.php -->
@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')
    <div class="auth-container">
        <div class="text-center mb-4">
            <img src="{{ asset('images/syntask-logo.png') }}" alt="SynTask Logo" height="60">
            <h1 class="h3 mt-3">Create an Account</h1>
            <p class="text-muted">Join SynTask and boost your productivity</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror"
                        name="first_name" value="{{ old('first_name') }}" required autofocus>
                    @error('first_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror"
                        name="last_name" value="{{ old('last_name') }}" required>
                    @error('last_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required>
                <div class="password-strength-container mt-1">
                    <div class="password-strength bg-danger" id="passwordStrength"></div>
                </div>
                <small class="text-muted">Use at least 8 characters with a mix of letters, numbers & symbols</small>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation"
                    required>
            </div>

            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>

            <div class="text-center">
                <p>Already have an account? <a href="{{ route('login') }}" class="text-decoration-none">Login</a></p>
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
