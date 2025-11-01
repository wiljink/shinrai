<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Branch;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('branch')->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('projects.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable',
            'name' => 'required',
            'description' => 'nullable|string',
        ]);

        Project::create($validated);

        return redirect()->route('projects.index')->with('success', 'Project created!');
    }

    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $branches = Branch::all();
        return view('projects.edit', compact('project', 'branches'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'branch_id' => 'nullable',
            'name' => 'required',
            'description' => 'nullable|string',
        ]);

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project updated!');
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted!');
    }
}
