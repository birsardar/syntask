<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = auth()->user()->tasks()->with('project');

        // Apply filters
        if ($request->has('category')) {
            $query->where('category', $request->category);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('project_id')) {
            $query->where('project_id', $request->project_id);
        }

        // Apply sorting
        $sort = $request->get('sort', 'recent');
        if ($sort === 'recent') {
            $query->latest();
        } elseif ($sort === 'active') {
            $query->where('status', '!=', 'Complete')->orderBy('due_date');
        }

        $tasks = $query->paginate(10);

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $projects = auth()->user()->projects;
        $projectId = $request->get('project_id');

        return view('tasks.create', compact('projects', 'projectId'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'category' => 'required|in:Work,Personal,Other',
            'status' => 'required|in:Active,In Progress,Complete',
            'project_id' => 'required|exists:projects,id',
        ]);

        // Verify the project belongs to the user
        $project = Project::findOrFail($validated['project_id']);
        $this->authorize('view', $project);

        $task = auth()->user()->tasks()->create($validated);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);
        $projects = auth()->user()->projects;

        return view('tasks.edit', compact('task', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'nullable|date',
            'category' => 'required|in:Work,Personal,Other',
            'status' => 'required|in:Active,In Progress,Complete',
            'project_id' => 'required|exists:projects,id',
        ]);

        // Verify the project belongs to the user
        $project = Project::findOrFail($validated['project_id']);
        $this->authorize('view', $project);

        $task->update($validated);

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()->route('tasks.index')
            ->with('success', 'Task deleted successfully!');
    }
}
