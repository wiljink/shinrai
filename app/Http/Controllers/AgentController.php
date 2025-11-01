<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AgentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if (auth()->user()->role !== 'agent') {
            abort(403, 'Unauthorized access.');
        }

        return view('dashboard.agent');
    }
}
