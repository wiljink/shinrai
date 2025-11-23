<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\CommissionService;

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
            // CRITICAL: The amount must be the total sale amount for the calculation to work.
            'amount' => 'required|numeric', 
            'status' => 'required',
        ]);

        // 1. Record the sale
        $sale = Sale::create($validated);

        // 2. Immediately trigger commission calculation and recording (New Logic)
        $commissionService = new CommissionService();
        $results = $commissionService->processSaleCommissions($sale);

        return redirect()->route('sales.index')
            ->with('success', 'Sale recorded and commissions calculated successfully! Agent Share: ' . number_format($results['agent_commission'], 2));
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
