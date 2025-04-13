<!-- resources/views/auth/2fa-challenge.blade.php -->
@extends('layouts.app')

@section('title', 'Two-Factor Authentication')

@section('content')
    <div class="auth-container">
        <div class="text-center mb-4">
            <img src="{{ asset('images/syntask-logo.png') }}" alt="SynTask Logo" height="60">
            <h1 class="h3 mt-3">Two-Factor Authentication</h1>
            <p class="text-muted">Enter the verification code from your authenticator app</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('2fa.verify') }}">
            @csrf
            <div class="mb-4">
                <label for="code" class="form-label">Verification Code</label>
                <input id="code" type="text" class="form-control @error('code') is-invalid @enderror" name="code"
                    autofocus autocomplete="off">
                @error('code')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-grid gap-2 mb-3">
                <button type="submit" class="btn btn-primary">Verify</button>
            </div>

            <div class="text-center">
                <p>Lost access to your authenticator app? Contact support for assistance.</p>
            </div>
        </form>
    </div>
@endsection
