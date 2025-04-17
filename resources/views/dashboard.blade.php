<!-- resources/views/dashboard.blade.php -->
@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Dashboard</h1>

    <!-- Stats Summary -->
    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Active Tasks</h5>
                    <p class="card-text display-4">{{ $taskStats['active'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <h5 class="card-title">In Progress</h5>
                    <p class="card-text display-4">{{ $taskStats['in_progress'] ?? 0 }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Completed</h5>
                    <p class="card-text display-4">{{ $taskStats['complete'] ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Active Projects -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Active Projects</h5>
                    <a href="{{ route('projects.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> New Project
                    </a>
                </div>
                <div class="card-body">
                    @if(count($projects ?? []) > 0)
                        @foreach($projects as $project)
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <h6><a href="{{ route('projects.show', $project->id) }}">{{ $project->name }}</a></h6>
                                    <div>
                                        <a href="{{ route('projects.edit', $project->id) }}" class="text-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-danger"
                                           onclick="event.preventDefault(); document.getElementById('delete-project-{{ $project->id }}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <form id="delete-project-{{ $project->id }}" action="{{ route('projects.destroy', $project->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                                <p class="text-muted small">{{ Str::limit($project->description, 100) }}</p>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $project->completion_percentage }}%"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1">
                                    <small class="text-muted">{{ $project->completion_percentage }}% Complete</small>
                                    <small class="text-muted">{{ $project->tasks_count ?? 0 }} Tasks</small>
                                </div>
                            </div>
                        @endforeach
                        @if(count($projects) > 3)
                            <div class="text-center">
                                <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-primary">View All Projects</a>
                            </div>
                        @endif
                    @else
                        <p class="text-center text-muted my-4">No active projects. <a href="{{ route('projects.create') }}">Create your first project</a>.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Tasks -->
        <div class="col-lg-6 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Tasks</h5>
                    <a href="{{ route('tasks.create') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-plus"></i> New Task
                    </a>
                </div>
                <div class="card-body">
                    <div class="mb-3 d-flex">
                        <div class="btn-group btn-group-sm me-auto">
                            <a href="{{ route('dashboard', ['sort' => 'recent']) }}" class="btn {{ request()->get('sort', 'recent') == 'recent' ? 'btn-primary' : 'btn-outline-primary' }}">Most Recent</a>
                            <a href="{{ route('dashboard', ['sort' => 'active']) }}" class="btn {{ request()->get('sort') == 'active' ? 'btn-primary' : 'btn-outline-primary' }}">Most Active</a>
                        </div>
                        <select class="form-select form-select-sm ms-1" style="width: auto" onchange="window.location = this.value">
                            <option value="{{ route('dashboard', ['sort' => request()->get('sort')]) }}">All Categories</option>
                            <option value="{{ route('dashboard', ['sort' => request()->get('sort'), 'category' => 'Work']) }}" {{ request()->get('category') == 'Work' ? 'selected' : '' }}>Work</option>
                            <option value="{{ route('dashboard', ['sort' => request()->get('sort'), 'category' => 'Personal']) }}" {{ request()->get('category') == 'Personal' ? 'selected' : '' }}>Personal</option>
                            <option value="{{ route('dashboard', ['sort' => request()->get('sort'), 'category' => 'Other']) }}" {{ request()->get('category') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        <select class="form-select form-select-sm ms-1" style="width: auto" onchange="window.location = this.value">
                            <option value="{{ route('dashboard', ['sort' => request()->get('sort'), 'category' => request()->get('category')]) }}">All Status</option>
                            <option value="{{ route('dashboard', ['sort' => request()->get('sort'), 'category' => request()->get('category'), 'status' => 'Active']) }}" {{ request()->get('status') == 'Active' ? 'selected' : '' }}>Active</option>
                            <option value="{{ route('dashboard', ['sort' => request()->get('sort'), 'category' => request()->get('category'), 'status' => 'In Progress']) }}" {{ request()->get('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="{{ route('dashboard', ['sort' => request()->get('sort'), 'category' => request()->get('category'), 'status' => 'Complete']) }}" {{ request()->get('status') == 'Complete' ? 'selected' : '' }}>Complete</option>
                        </select>
                    </div>

                    @if(count($tasks ?? []) > 0)
                        @foreach($tasks as $task)
                            <div class="mb-3 pb-3 border-bottom">
                                <div class="d-flex justify-content-between">
                                    <h6><a href="{{ route('tasks.show', $task->id) }}">{{ $task->title }}</a></h6>
                                    <div>
                                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-primary me-2">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="text-danger"
                                           onclick="event.preventDefault(); document.getElementById('delete-task-{{ $task->id }}').submit();">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                        <form id="delete-task-{{ $task->id }}" action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                                <p class="text-muted small">{{ Str::limit($task->description, 80) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <span class="badge bg-{{ $task->status == 'Active' ? 'primary' : ($task->status == 'In Progress' ? 'warning' : 'success') }}">
                                            {{ $task->status }}
                                        </span>
                                        <span class="badge bg-secondary ms-1">{{ $task->category }}</span>
                                    </div>
                                    <small class="text-muted">{{ $task->due_date ? date('M d, Y', strtotime($task->due_date)) : 'No due date' }}</small>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-flex justify-content-center">
                            {{ $tasks->appends(request()->all())->links() }}
                        </div>
                    @else
                        <p class="text-center text-muted my-4">No tasks found. <a href="{{ route('tasks.create') }}">Create your first task</a>.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
