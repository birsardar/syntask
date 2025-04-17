<!-- resources/views/projects/index.blade.php -->
@extends('layouts.app')

@section('title', 'Projects')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Projects</h1>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> New Project
            </a>
        </div>

        @if (count($projects) > 0)
            <div class="row">
                @foreach ($projects as $project)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">{{ $project->name }}</h5>
                                    <span class="badge {{ $project->status == 'Active' ? 'bg-success' : 'bg-secondary' }}">
                                        {{ $project->status }}
                                    </span>
                                </div>
                                <p class="card-text text-muted">{{ Str::limit($project->description, 150) }}</p>

                                <div class="progress progress-thin mb-2">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $project->completion_percentage }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between small text-muted mb-3">
                                    <span>{{ $project->completion_percentage }}% Complete</span>
                                    <span>{{ $project->tasks_count ?? count($project->tasks) }} Tasks</span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('projects.show', $project->id) }}"
                                        class="btn btn-sm btn-outline-primary">View Details</a>
                                    <div>
                                        <a href="{{ route('projects.edit', $project->id) }}"
                                            class="btn btn-sm btn-outline-secondary me-1">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-outline-danger"
                                            onclick="event.preventDefault(); document.getElementById('delete-project-{{ $project->id }}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <form id="delete-project-{{ $project->id }}"
                                            action="{{ route('projects.destroy', $project->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="d-flex justify-content-center">
                {{ $projects->links() }}
            </div>
        @else
            <div class="card">
                <div class="card-body text-center py-5">
                    <i class="fas fa-project-diagram fa-3x text-muted mb-3"></i>
                    <h4>No Projects Found</h4>
                    <p class="text-muted">You haven't created any projects yet.</p>
                    <a href="{{ route('projects.create') }}" class="btn btn-primary">Create Your First Project</a>
                </div>
            </div>
        @endif
    </div>
@endsection
