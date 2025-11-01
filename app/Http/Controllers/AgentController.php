<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AgentController extends Controller
{
    /**
     * Display a list of all agents (for Admin only)
     */
    public function index()
    {
        // Restrict access to admin only
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        // Get all users with role 'agent'
        $agents = User::where('role', 'agent')->get();

        return view('dashboard.agents', compact('agents'));
    }

    /**
     * Approve an agent (Admin only)
     */
    public function approve($id)
    {
        // Restrict access to admin only
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $agent = User::findOrFail($id);
        $agent->is_approved = 1;
        $agent->save();

        return redirect()->route('agents.index')
            ->with('status', 'Agent approved successfully.');
    }

    /**
     * Reject or deactivate an agent (Admin only)
     */
    public function reject($id)
    {
        // Restrict access to admin only
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized access.');
        }

        $agent = User::findOrFail($id);
        $agent->is_approved = 0;
        $agent->save();

        return redirect()->route('admin.agents.index')
            ->with('status', 'Agent deactivated successfully.');
    }
}
