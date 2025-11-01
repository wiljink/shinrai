<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with(['property', 'agent'])->paginate(10);
        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $properties = Property::where('status', 'available')->get();
        $agents = User::where('role', 'agent')->get();
        return view('sales.create', compact('properties', 'agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required',
            'agent_id' => 'required',
            'buyer_name' => 'required',
            'sale_date' => 'required|date',
            'amount' => 'required|numeric',
            'status' => 'required',
        ]);

        Sale::create($validated);

        return redirect()->route('sales.index')->with('success', 'Sale recorded successfully!');
    }

    public function show(Sale $sale)
    {
        return view('sales.show', compact('sale'));
    }

    public function edit(Sale $sale)
    {
        $properties = Property::all();
        $agents = User::where('role', 'agent')->get();
        return view('sales.edit', compact('sale', 'properties', 'agents'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'property_id' => 'required',
            'agent_id' => 'required',
            'buyer_name' => 'required',
            'sale_date' => 'required|date',
            'amount' => 'required|numeric',
            'status' => 'required',
        ]);

        $sale->update($validated);

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully!');
    }

    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index')->with('success', 'Sale deleted!');
    }
}
