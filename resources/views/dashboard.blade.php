<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Dashboard</h1>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">Update your personal information and account settings.</p>
                    <a href="{{ route('profile') }}" class="btn btn-outline-primary">Manage Profile</a>
                </div>
            </div>
        </div>
        <!-- Add more dashboard cards here as needed -->
    </div>
</div>
@endsection
