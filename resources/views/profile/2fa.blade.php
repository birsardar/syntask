<!-- resources/views/profile/2fa.blade.php -->
@extends('layouts.app')

@section('title', 'Two-Factor Authentication')

@section('content')
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Two-Factor Authentication</h5>
                        <a href="{{ route('profile') }}" class="btn btn-sm btn-outline-secondary">Back to Profile</a>
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="alert alert-info">
                            <p>Two-factor authentication adds an extra layer of security to your account. When enabled,
                                you'll need to provide a verification code in addition to your password when logging in.</p>
                        </div>

                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h6 class="mb-0">Status:
                                    @if ($user->two_factor_enabled)
                                        <span class="badge bg-success">Enabled</span>
                                    @else
                                        <span class="badge bg-secondary">Disabled</span>
                                    @endif
                                </h6>
                            </div>
                            <form method="POST" action="{{ route('profile.2fa.toggle') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    @if ($user->two_factor_enabled)
                                        Disable 2FA
                                    @else
                                        Enable 2FA
                                    @endif
                                </button>
                            </form>
                        </div>

                        @if ($user->two_factor_enabled)
                            <hr>
                            <div class="mt-4">
                                <h6>Recovery Codes</h6>
                                <p class="text-muted">Recovery codes can be used to access your account in case you lose
                                    your device.</p>
                                <div class="alert alert-warning">
                                    <p class="mb-0"><strong>Important:</strong> Store these recovery codes in a secure
                                        password manager. They cannot be viewed again.</p>
                                </div>
                                <div class="bg-light p-3 rounded mb-3">
                                    <code class="d-block">XXXX-XXXX-XXXX-XXXX</code>
                                    <code class="d-block">XXXX-XXXX-XXXX-XXXX</code>
                                    <code class="d-block">XXXX-XXXX-XXXX-XXXX</code>
                                    <code class="d-block">XXXX-XXXX-XXXX-XXXX</code>
                                    <code class="d-block">XXXX-XXXX-XXXX-XXXX</code>
                                </div>
                            </div>
                        @endif

                        @if (!$user->two_factor_enabled)
                            <hr>
                            <div class="mt-4">
                                <h6>Setup Instructions</h6>
                                <p>Follow these steps to set up two-factor authentication:</p>
                                <ol>
                                    <li>Click the "Enable 2FA" button above.</li>
                                    <li>Install an authenticator app (Google Authenticator, Microsoft Authenticator, Authy,
                                        etc.).</li>
                                    <li>Set up your account in the app using the provided QR code.</li>
                                    <li>Enter the verification code from the app to confirm setup.</li>
                                </ol>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
