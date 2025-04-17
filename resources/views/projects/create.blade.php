<!-- resources/views/projects/create.blade.php -->
@extends('layouts.app')

@section('title', 'Create Project')

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1>Create New Project</h1>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('projects.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Project Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description"
                                    rows="4">{{ old('description') }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" id="status"
                                    name="status">
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                                    <option value="Complete" {{ old('status') == 'Complete' ? 'selected' : '' }}>Complete
                                    </option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('projects.index') }}" class="btn btn-outline-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">Create Project</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Creating a Project</h5>
                        <p class="card-text">Projects help you organize your tasks in meaningful groups.</p>
                        <ul class="small text-muted">
                            <li>Give your project a clear, descriptive name</li>
                            <li>Add a detailed description to clarify the project's purpose</li>
                            <li>New projects are set to "Active" by default</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
