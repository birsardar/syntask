@extends('layouts.app')

@section('title', 'My Tasks')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Tasks</h2>
        <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create Task</a>
    </div>

    @if ($tasks->count())
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Category</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->project->name ?? '-' }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $task->status === 'Complete' ? 'success' : ($task->status === 'In Progress' ? 'warning' : 'secondary') }}">
                                    {{ $task->status }}
                                </span>
                            </td>
                            <td>{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M, Y') : '-' }}</td>
                            <td>{{ $task->category }}</td>
                            <td>
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-sm btn-info text-white">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-warning text-white">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this task?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div>
            {{ $tasks->links() }} {{-- Laravel Pagination --}}
        </div>
    @else
        <p class="text-muted">No tasks found.</p>
    @endif
@endsection
