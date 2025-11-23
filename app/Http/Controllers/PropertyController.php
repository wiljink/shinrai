<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    private function redirectToProperties()
    {
        $role = auth()->user()->role;

        return $role === 'sales_manager'
            ? redirect()->route('sales_manager.properties.index')
            : redirect()->route('sales_agent.properties.index');
    }

    public function index()
    {
        $properties = Property::with(['project', 'agent', 'images'])->paginate(10);
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        $projects = Project::all();
        $agents = User::where('role', 'sales_agent')->get();

        return view('properties.create', compact('projects', 'agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required',
            'agent_id' => 'required',
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
        ]);

        Property::create($validated);

        return $this->redirectToProperties()
            ->with('success', 'Property added successfully!');
    }

    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $projects = Project::all();
        $agents = User::where('role', 'sales_agent')->get();

        return view('properties.edit', compact('property', 'projects', 'agents'));
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'project_id' => 'required',
            'agent_id' => 'required',
            'name' => 'required',
            'location' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
        ]);

        $property->update($validated);

        return $this->redirectToProperties()
            ->with('success', 'Property updated successfully!');
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return $this->redirectToProperties()
            ->with('success', 'Property deleted!');
    }
}
