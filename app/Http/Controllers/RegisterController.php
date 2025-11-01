<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        dd($request->all());
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'   => ['required', 'confirmed', Rules\Password::defaults()],
            'role'       => ['required', 'in:broker,agent,buyer'],
            'invited_by' => ['nullable', 'string', 'max:255'],
            'birthday'   => ['required', 'date'],
            'gender'     => ['required', 'in:male,female'],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'role'       => $request->role,
            'invited_by' => $request->invited_by,
            'birthday'   => $request->birthday,
            'gender'     => $request->gender,
            'is_approved' => false, // 👈 pending admin approval
        ]);

        return redirect()->route('login')->with('status', 'Registration successful! Please wait for admin approval before logging in.');
    }
}
