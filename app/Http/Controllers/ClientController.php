<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    /**
     * Display a listing of clients/leads (Accessible by all).
     */
    public function index()
    {
        // Default query for all clients
        $clients = Client::with('assignedAgent');

        // Agents can only see their own clients
        if (Auth::user()->role === 'agent') {
            $clients->where('assigned_agent_id', Auth::id());
        }

        $clients = $clients->paginate(10);

        return view('clients.index', compact('clients'));
    }

    /**
     * Store a newly created client/lead.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'lead_source' => 'nullable|string|max:255',
            'assigned_agent_id' => 'required|exists:users,id',
        ]);

        Client::create($validated);

        return redirect()->route('clients.index')->with('success', 'Lead successfully recorded.');
    }

    // ... Other CRUD methods (show, edit, update, destroy) would go here ...
}