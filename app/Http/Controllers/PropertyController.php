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
        return view('sales_agent.properties.index', compact('properties'));
    }

    public function create()
    {
        $projects = Project::all();
        $agents = User::where('role', 'sales_agent')->get();

        return view('sales_agent.properties.create', compact('projects', 'agents'));
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'project_id' => 'required|exists:projects,id',
        'agent_id' => 'required|exists:users,id',
        'name' => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'price' => 'required|numeric',
        'status' => 'required|in:available,reserved,sold',
        'description' => 'nullable|string',

        'property_type' => 'required|string|in:House&Lot,Lot Only,Condo,Commercial,Apartment,Townhouse',
        'listing_category' => 'nullable|string',
        'property_details' => 'nullable|string',
        'selling_price' => 'nullable|numeric',
        'commission_offered' => 'nullable|string',
        'conditions' => 'nullable|string',
        'listing_owner' => 'nullable|string',
        'owner_contact_number' => 'nullable|string',

        // House & Lot / Townhouse
        'lot_area' => 'nullable|numeric|required_if:property_type,House&Lot,Townhouse',
        'floor_area' => 'nullable|numeric|required_if:property_type,House&Lot,Townhouse,Condo,Commercial',
        'bedrooms' => 'nullable|integer|required_if:property_type,House&Lot,Townhouse',
        'bathrooms' => 'nullable|integer|required_if:property_type,House&Lot,Townhouse',
        'carport' => 'nullable|string',

        // Lot Only
        'lot_classification' => 'nullable|string|required_if:property_type,Lot Only',

        // Condo
        'unit_type' => 'nullable|string|required_if:property_type,Condo',
        'parking' => 'nullable|string',

        // Commercial
        'commercial_type' => 'nullable|string|required_if:property_type,Commercial',
        'monthly_income' => 'nullable|numeric',

        // Apartment
        'total_units' => 'nullable|integer|required_if:property_type,Apartment',
    ]);

    $property = Property::create($validated);

    // Handle images if uploaded
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('properties', 'public');
            $property->images()->create(['path' => $path]);
        }
    }

    return $this->redirectToProperties()->with('success', 'Property added successfully!');
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
        'project_id' => 'sometimes|exists:projects,id',
        'agent_id' => 'sometimes|exists:users,id',
        'name' => 'sometimes|string|max:255',
        'location' => 'sometimes|string|max:255',
        'price' => 'sometimes|numeric',
        'status' => 'sometimes|in:available,reserved,sold',
        'description' => 'nullable|string',
        'property_type' => 'sometimes|string|in:House&Lot,Lot Only,Condo,Commercial,Apartment,Townhouse',
        // (repeat the conditional validation rules here, same as store)
    ]);

    $property->update($validated);

    return $this->redirectToProperties()->with('success', 'Property updated successfully!');
}

    public function destroy(Property $property)
    {
        $property->delete();

        return $this->redirectToProperties()
            ->with('success', 'Property deleted!');
    }
}
