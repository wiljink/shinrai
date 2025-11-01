<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Show the registration form.
     */
    public function create()
    {
        $branches = Branch::all(); // assuming you have a Branch model
        return view('auth.register', compact('branches'));
    }

    /**
     * Handle registration.
     */
    public function store(Request $request)
    {
        $request->validate([
            'role' => 'required|in:broker,agent,buyer',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'invited_by' => 'nullable|string|max:255',
            'birthday' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string', // no min, no confirm
        ]);

        $user = User::create([
            'role' => $request->role,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'invited_by' => $request->invited_by,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_approved' => false,
        ]);

        return redirect('/')
            ->with('status', 'Your account has been created and is pending admin approval.');
        }

    }
