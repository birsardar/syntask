@extends('layouts.app')

@section('title', 'Task Details')

@section('content')
    <div class="container">
        <h1 class="mb-4">Task Details</h1>

        <div class="card mb-3">
            <div class="card-body">
                <h4 class="card-title">{{ $task->title }}</h4>
                <p class="card-text">
                    <strong>Description:</strong><br>
                    {{ $task->description ?? 'No description provided.' }}
                </p>
                <p class="card-text">
                    <strong>Status:</strong>
                    <span
                        class="badge bg-{{ $task->status === 'Complete' ? 'success' : ($task->status === 'In Progress' ? 'warning' : 'secondary') }}">
                        {{ $task->status }}
                    </span>
                </p>
                <p class="card-text"><strong>Due Date:</strong>
                    {{ $task->due_date ? $task->due_date->format('Y-m-d') : 'No due date' }}</p>
                <p class="card-text"><strong>Category:</strong> {{ $task->category }}</p>
                <p class="card-text"><strong>Project:</strong> {{ $task->project->name ?? 'N/A' }}</p>
                <p class="card-text"><strong>Created At:</strong> {{ $task->created_at->format('Y-m-d H:i') }}</p>
                <p class="card-text"><strong>Last Updated:</strong> {{ $task->updated_at->format('Y-m-d H:i') }}</p>
            </div>
        </div>

        <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-primary">Edit Task</a>
        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-inline"
            onsubmit="return confirm('Are you sure you want to delete this task?');">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete Task</button>
        </form>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
@endsection
