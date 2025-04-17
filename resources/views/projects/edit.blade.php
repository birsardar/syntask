<!-- resources/views/projects/edit.blade.php -->
@extends('layouts.app')

@section('title', 'Edit Project')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1>Edit Project</h1>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('projects.update', $project->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Project Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name', $project->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4">{{ old('description', $project->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="Active"
                                        {{ old('status', $project->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Complete"
                                        {{ old('status', $project->status) == 'Complete' ? 'selected' : '' }}>Complete
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('projects.show', $project->id) }}"
                                    class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Update Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Project Details</h5>
                        <p class="card-text">Created on {{ $project->created_at->format('M d, Y') }}</p>
                        <p class="card-text">Last updated {{ $project->updated_at->diffForHumans() }}</p>

                        <div class="progress progress-thin mb-2">
                            <div class="progress-bar" role="progressbar"
                                style="width: {{ $project->completion_percentage }}%"></div>
                        </div>
                        <div class="d-flex justify-content-between small text-muted">
                            <span>{{ $project->completion_percentage }}% Complete</span>
                            <span>{{ count($project->tasks) }} Tasks</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body bg-light">
                        <h6 class="card-title">Danger Zone</h6>
                        <p class="small text-muted">Deleting this project will also delete all tasks associated with it.</p>
                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100"
                                onclick="return confirm('Are you sure you want to delete this project? All associated tasks will be deleted too.')">
                                Delete Project
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
