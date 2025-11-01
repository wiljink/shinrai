<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Branch;

class AdminController extends Controller
{
    /**
     * Require authentication for all admin routes.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Admin dashboard.
     */
    public function index()
    {
        // Optional: check if user is admin
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        // Example data
        $users = User::count();
        $branches = Branch::count();

        return view('admin.dashboard', compact('users', 'branches'));
    }

    /**
     * Manage users list (optional feature)
     */
    public function users()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
}
