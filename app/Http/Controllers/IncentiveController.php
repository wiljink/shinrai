<?php

namespace App\Http\Controllers;

use App\Models\Incentive;
use App\Models\User;
use Illuminate\Http\Request;

class IncentiveController extends Controller
{
    public function index()
    {
        $incentives = Incentive::with('agent')->paginate(10);
        return view('incentives.index', compact('incentives'));
    }

    public function create()
    {
        $agents = User::where('role', 'agent')->get();
        return view('incentives.create', compact('agents'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'agent_id' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);

        Incentive::create($validated);

        return redirect()->route('incentives.index')->with('success', 'Incentive added!');
    }

    public function show(Incentive $incentive)
    {
        return view('incentives.show', compact('incentive'));
    }

    public function edit(Incentive $incentive)
    {
        $agents = User::where('role', 'agent')->get();
        return view('incentives.edit', compact('incentive', 'agents'));
    }

    public function update(Request $request, Incentive $incentive)
    {
        $validated = $request->validate([
            'agent_id' => 'required',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'required',
        ]);

        $incentive->update($validated);

        return redirect()->route('incentives.index')->with('success', 'Incentive updated!');
    }

    public function destroy(Incentive $incentive)
    {
        $incentive->delete();
        return redirect()->route('incentives.index')->with('success', 'Incentive deleted!');
    }
}
