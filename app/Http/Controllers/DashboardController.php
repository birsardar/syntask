<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $projects = $user->projects()->where('status', 'Active')->latest()->get();

        $taskQuery = $user->tasks();

        // Apply filters
        if ($request->has('category')) {
            $taskQuery->where('category', $request->category);
        }

        if ($request->has('status')) {
            $taskQuery->where('status', $request->status);
        }

        // Apply sorting
        $sort = $request->get('sort', 'recent');
        if ($sort === 'recent') {
            $taskQuery->latest();
        } elseif ($sort === 'active') {
            $taskQuery->where('status', '!=', 'Complete')->orderBy('due_date');
        }

        $tasks = $taskQuery->with('project')->paginate(10);

        $taskStats = [
            'active' => $user->tasks()->where('status', 'Active')->count(),
            'in_progress' => $user->tasks()->where('status', 'In Progress')->count(),
            'complete' => $user->tasks()->where('status', 'Complete')->count(),
        ];

        // dd($taskStats);

        return view('dashboard', compact('projects', 'tasks', 'taskStats'));
    }

    public function report(Request $request)
    {
        $user = auth()->user();
        $projects = $user->projects;

        // Filter by project
        $projectId = $request->get('project_id');
        if ($projectId) {
            $projects = $projects->where('id', $projectId);
        }

        // Get task statistics
        $taskStats = [
            'active' => Task::where('user_id', $user->id)
                ->when($projectId, function ($query) use ($projectId) {
                    return $query->where('project_id', $projectId);
                })
                ->where('status', 'Active')
                ->count(),
            'in_progress' => Task::where('user_id', $user->id)
                ->when($projectId, function ($query) use ($projectId) {
                    return $query->where('project_id', $projectId);
                })
                ->where('status', 'In Progress')
                ->count(),
            'complete' => Task::where('user_id', $user->id)
                ->when($projectId, function ($query) use ($projectId) {
                    return $query->where('project_id', $projectId);
                })
                ->where('status', 'Complete')
                ->count(),
        ];

        // Filter by category
        $category = $request->get('category');
        if ($category) {
            $taskStats = [
                'active' => Task::where('user_id', $user->id)
                    ->where('category', $category)
                    ->where('status', 'Active')
                    ->count(),
                'in_progress' => Task::where('user_id', $user->id)
                    ->where('category', $category)
                    ->where('status', 'In Progress')
                    ->count(),
                'complete' => Task::where('user_id', $user->id)
                    ->where('category', $category)
                    ->where('status', 'Complete')
                    ->count(),
            ];
        }

        return view('dashboard.report', compact('projects', 'taskStats', 'projectId', 'category'));
    }
}
