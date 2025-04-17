<!-- resources/views/welcome.blade.php -->
@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
    <div class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold">Welcome to SynTask</h1>
                <p class="lead">Streamline your workflow, boost productivity, and collaborate seamlessly.</p>
                <div class="mt-4">
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-primary btn-lg me-2">Get Started</a>
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">Login</a>
                    @else
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-lg">Go to Dashboard</a>
                    @endguest
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/hero-image.png') }}" alt="Task Management" class="img-fluid">
            </div>
        </div>
    </div>
@endsection
