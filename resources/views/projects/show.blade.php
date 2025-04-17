<!-- resources/views/projects/show.blade.php -->
@extends('layouts.app')

@section('title', $project->name)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1>{{ $project->name }}</h1>
                <p class="text-muted">{{ $project->description }}</p>
            </div>
            <div>
                <a href="{{ route('tasks.create', ['project_id' => $project->id]) }}" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Add Task
                </a>
                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-outline-secondary">
                    <i class="fas fa-edit"></i> Edit Project
                </a>
            </div>
        </div>

        <!-- Project Progress -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Project Progress</h5>
                        <div class="progress mt-2" style="height: 20px;">
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $project->completion_percentage }}%"
                                aria-valuenow="{{ $project->completion_percentage }}" aria-valuemin="0" aria-valuemax="100">
                                {{ $project->completion_percentage }}%
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row text-center">
                            <div class="col-4">
                                <h5>{{ $tasks->where('status', 'Active')->count() }}</h5>
                                <p class="text-muted">Active</p>
                            </div>
                            <div class="col-4">
                                <h5>{{ $tasks->where('status', 'In Progress')->count() }}</h5>
                                <p class="text-muted">In Progress</p>
                            </div>
                            <div class="col-4">
                                <h5>{{ $tasks->where('status', 'Complete')->count() }}</h5>
                                <p class="text-muted">Completed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Tasks</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-8">
