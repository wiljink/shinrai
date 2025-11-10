<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Define roles in one place for consistency
    protected $roles = [
    'admin' => 'Admin',
    'sales_agent' => 'Sales Agent',
    'sales_manager' => 'Sales Manager',
];

    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with('branch')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $branches = Branch::all();
        $roles = $this->roles;
        return view('admin.users.create', compact('roles', 'branches'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name'  => 'required|string|max:255',
        'email'      => 'required|email|unique:users,email',
        'password'   => 'required|string|min:6',
        'role'       => 'required|string|in:' . implode(',', array_keys($this->roles)),
        'branch_id'  => 'nullable|exists:branches,id',
        'birthday'   => 'nullable|date',
        'gender'     => 'nullable|in:male,female',
    ]);

    //dd($validated); // now runs correctly when validation passes

    User::create([
        'first_name'  => $validated['first_name'],
        'last_name'   => $validated['last_name'],
        'email'       => $validated['email'],
        'password'    => Hash::make($validated['password']),
        'role'        => $validated['role'],
        'branch_id'   => $validated['branch_id'] ?? null,
        'birthday'    => $validated['birthday'] ?? null,
        'gender'      => $validated['gender'] ?? null,
        'is_approved' => false,
    ]);

    return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
}



    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $branches = Branch::all();
        $roles = $this->roles;
        return view('admin.users.edit', compact('user', 'roles', 'branches'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $user->id,
            'role'       => 'required|string|in:' . implode(',', $this->roles),
            'branch_id'  => 'nullable|exists:branches,id',
            'birthday'   => 'nullable|date',
            'gender'     => 'nullable|in:male,female',
            'password'   => 'nullable|string|min:6',
        ]);

        $user->first_name = $validated['first_name'];
        $user->last_name  = $validated['last_name'];
        $user->email      = $validated['email'];
        $user->role       = $validated['role'];
        $user->branch_id  = $validated['branch_id'] ?? null;
        $user->birthday   = $validated['birthday'] ?? null;
        $user->gender     = $validated['gender'] ?? null;

        // Update password only if provided
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
   public function destroy($id)
{
    $user = User::findOrFail($id); // Fetch the user by ID
    $user->delete();
    return back()->with('success', 'User deleted successfully.');
}

/**
 * Approve a user registration.
 */
public function approve($id)
{
    $user = User::findOrFail($id); // Fetch the user by ID
    $user->update(['is_approved' => true]);
    return back()->with('success', 'User approved successfully.');
}

/**
 * Deactivate a user.
 */
public function deactivate($id)
{
    $user = User::findOrFail($id); // Fetch the user by ID
    $user->update(['is_approved' => false]);
    return back()->with('success', 'User deactivated.');
}

}
