<!-- resources/views/profile/index.blade.php -->
@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Profile Settings</h1>

    @if(session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="list-group">
                <a href="#profile-info" class="list-group-item list-group-item-action active" data-bs-toggle="list">Personal Information</a>
                <a href="#profile-photo" class="list-group-item list-group-item-action" data-bs-toggle="list">Profile Photo</a>
                <a href="#email-settings" class="list-group-item list-group-item-action" data-bs-toggle="list">Email Settings</a>
                <a href="#password-settings" class="list-group-item list-group-item-action" data-bs-toggle="list">Password</a>
                <a href="{{ route('profile.2fa') }}" class="list-group-item list-group-item-action">Two-Factor Authentication</a>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content">
                <!-- Personal Information -->
                <div class="tab-pane fade show active" id="profile-info">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="first_name" class="form-label">First Name</label>
                                        <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name', $user->first_name) }}" required>
                                        @error('first_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label for="last_name" class="form-label">Last Name</label>
                                        <input id="last_name" type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name', $user->last_name) }}" required>
                                        @error('last_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Profile Photo -->
                <div class="tab-pane fade" id="profile-photo">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Profile Photo</h5>
                        </div>
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="position-relative">
                                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->full_name }}" class="rounded-circle img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <form method="POST" action="{{ route('profile.photo') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="photo" class="form-label">Upload New Photo</label>
                                            <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" accept="image/*" required>
                                            <div class="form-text">Maximum file size: 2MB. Supported formats: JPEG, PNG, GIF.</div>
                                            @error('photo')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary">Upload Photo</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Email Settings -->
                <div class="tab-pane fade" id="email-settings">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Email Settings</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.email') }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="current_email" class="form-label">Current Email Address</label>
                                    <input id="current_email" type="email" class="form-control" value="{{ $user->email }}" disabled>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">New Email Address</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Current Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                    <div class="form-text">We need your current password to confirm your identity.</div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Change Email</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Password Settings -->
                <div class="tab-pane fade" id="password-settings">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">Change Password</h5>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('profile.password') }}">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Current Password</label>
                                    <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required>
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">New Password</label>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required>
                                    <div class="password-strength-container mt-1">
                                        <div class="password-strength bg-danger" id="passwordStrength" style="width: 0%;"></div>
                                    </div>
                                    <div class="form-text">Use at least 8 characters with a mix of letters, numbers & symbols</div>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        if (passwordInput) {
            passwordInput.addEventListener('input', function() {
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
        }
    });
</script>
@endsection

