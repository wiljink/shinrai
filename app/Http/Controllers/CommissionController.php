<?php

namespace App\Http\Controllers;

use App\Models\Commission;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;

class CommissionController extends Controller
{
    public function index()
    {
        $commissions = Commission::with(['sale', 'agent'])->paginate(10);
        return view('commissions.index', compact('commissions'));
    }

    public function create()
    {
        $sales = Sale::all();
        $agents = User::where('role', 'agent')->get();
        return view('commissions.create', compact('sales', 'agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sale_id' => 'required',
            'agent_id' => 'required',
            'amount' => 'required|numeric',
            'status' => 'required',
        ]);

        Commission::create($validated);

        return redirect()->route('commissions.index')->with('success', 'Commission recorded successfully!');
    }

    public function show(Commission $commission)
    {
        return view('commissions.show', compact('commission'));
    }

    public function edit(Commission $commission)
    {
        $sales = Sale::all();
        $agents = User::where('role', 'agent')->get();
        return view('commissions.edit', compact('commission', 'sales', 'agents'));
    }

    public function update(Request $request, Commission $commission)
    {
        $validated = $request->validate([
            'sale_id' => 'required',
            'agent_id' => 'required',
            'amount' => 'required|numeric',
            'status' => 'required',
        ]);

        $commission->update($validated);

        return redirect()->route('commissions.index')->with('success', 'Commission updated!');
    }

    public function destroy(Commission $commission)
    {
        $commission->delete();
        return redirect()->route('commissions.index')->with('success', 'Commission deleted!');
    }
}
