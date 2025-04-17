@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <div class="container">
        <h1 class="mb-4">Edit Task</h1>

        <form action="{{ route('tasks.update', $task->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="title" class="form-label">Task Title</label>
                <input type="text" name="title" id="title" class="form-control"
                    value="{{ old('title', $task->title) }}" required>
                @error('title')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description (optional)</label>
                <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $task->description) }}</textarea>
                @error('description')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="due_date" class="form-label">Due Date</label>
                <input type="date" name="due_date" id="due_date" class="form-control"
                    value="{{ old('due_date', $task->due_date ? $task->due_date->format('Y-m-d') : '') }}">
                @error('due_date')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select" required>
                    <option value="">Choose...</option>
                    @foreach (['Work', 'Personal', 'Other'] as $category)
                        <option value="{{ $category }}"
                            {{ old('category', $task->category) === $category ? 'selected' : '' }}>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
                @error('category')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select" required>
                    <option value="">Choose...</option>
                    @foreach (['Active', 'In Progress', 'Complete'] as $status)
                        <option value="{{ $status }}"
                            {{ old('status', $task->status) === $status ? 'selected' : '' }}>
                            {{ $status }}
                        </option>
                    @endforeach
                </select>
                @error('status')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="project_id" class="form-label">Assign to Project</label>
                <select name="project_id" id="project_id" class="form-select" required>
                    <option value="">Choose a project</option>
                    @foreach ($projects as $project)
                        <option value="{{ $project->id }}"
                            {{ old('project_id', $task->project_id) == $project->id ? 'selected' : '' }}>
                            {{ $project->name }}
                        </option>
                    @endforeach
                </select>
                @error('project_id')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-success">Update Task</button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
