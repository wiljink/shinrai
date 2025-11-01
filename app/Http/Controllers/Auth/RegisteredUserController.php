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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,agent'],
            'branch_id' => ['nullable', 'integer'],
        ]);

        // ✅ Create the user but keep them pending admin approval
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'branch_id' => $request->branch_id,
            'is_approved' => 0, // 👈 mark as not approved
        ]);

        event(new Registered($user));

        // ❌ remove Auth::login($user)
        // ✅ replace it with redirect + message
        return redirect()
            ->route('login')
            ->with('status', 'Your account has been created and is pending admin approval.');
    }
}
