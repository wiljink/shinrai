<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $roles = [
        'admin'                 => 'Sales Director',
        'sales_manager'         => 'Sales Manager',
        'senior_sales_affiliate'=> 'Senior Sales & Mktg Affiliate',
        'junior_sales_affiliate'=> 'Junior Sales & Mktg Affiliate',
    ];

    /** Display a listing of users */
    public function index()
    {
        if (auth()->user()->role === 'sales_manager') {
            // Only users under this manager
            $users = User::where('manager_id', auth()->id())->paginate(10);
            return view('sales_manager.users.index', compact('users'));
        }

        // Admin sees all users
        $users = User::with(['branch', 'manager'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /** Show the form for creating a new user */
    public function create()
    {
        $branches = Branch::all();
        $roles = $this->roles;

        if (auth()->user()->role === 'sales_manager') {
            return view('sales_manager.users.create', compact('roles', 'branches'));
        }

        // Admin also selects manager
        $managers = User::where('role', 'sales_manager')->get();
        return view('admin.users.create', compact('roles', 'branches', 'managers'));
    }

  /** Store a newly created user */
public function store(Request $request)
{
    $isAdmin = auth()->user()->role === 'admin';

    // VALIDATION ----------------------------------
    $rules = [
        'first_name'      => 'required|string|max:255',
        'last_name'       => 'required|string|max:255',
        'email'           => 'required|email|unique:users,email',
        'role'            => 'required|string|in:' . implode(',', array_keys($this->roles)),
        'branch_id'       => 'nullable|exists:branches,id',
        'birthday'        => 'nullable|date',
        'gender'          => 'nullable|in:male,female',
        'manager_id'      => 'nullable|exists:users,id',
        'commission_rate' => 'nullable|numeric|min:0|max:100',
    ];

    // ADMIN must assign password
    if ($isAdmin) {
        $rules['password'] = 'required|string|min:6|confirmed';
    }

    // SALES MANAGER — no password sent
    if (!$isAdmin) {
        $rules['password'] = 'nullable';
    }

    $validated = $request->validate($rules);


    // PASSWORD HANDLING ----------------------------------
    if ($isAdmin) {
        // Admin decides password
        $finalPassword = Hash::make($request->password);
    } else {
        // Sales Manager — auto-generate temporary password
        $temp = 'Temp' . rand(1000, 9999); 
        $finalPassword = Hash::make($temp);
    }


    // CREATE USER ----------------------------------------
    User::create([
        'first_name'      => $validated['first_name'],
        'last_name'       => $validated['last_name'],
        'email'           => $validated['email'],
        'password'        => $finalPassword,
        'role'            => $validated['role'],
        'branch_id'       => $validated['branch_id'] ?? null,
        'birthday'        => $validated['birthday'] ?? null,
        'gender'          => $validated['gender'] ?? null,
        'manager_id'      => $validated['manager_id'] ?? null,
        'commission_rate' => $validated['commission_rate'] ?? 0,
        'is_approved'     => $isAdmin ? true : false,
    ]);


    // REDIRECT -------------------------------------------
    if ($isAdmin) {
        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    return redirect()
        ->route('sales_manager.users.index')
        ->with('success', 'User created successfully and pending approval.');
}


    /** Edit user (Admin only) */
    public function edit($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $user = User::findOrFail($id);
        $branches = Branch::all();
        $roles = $this->roles;
        $managers = User::where('role', 'sales_manager')->get();

        return view('admin.users.edit', compact('user', 'roles', 'branches', 'managers'));
    }

    /** Update user (Admin only) */
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        $user = User::findOrFail($id);

        $validated = $request->validate([
            'first_name'      => 'required|string|max:255',
            'last_name'       => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $user->id,
            'role'            => 'required|string|in:' . implode(',', array_keys($this->roles)),
            'branch_id'       => 'nullable|exists:branches,id',
            'birthday'        => 'nullable|date',
            'gender'          => 'nullable|in:male,female',
            'manager_id'      => 'nullable|exists:users,id',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'password'        => 'nullable|string|min:6',
        ]);

        $data = $validated;
        if (!empty($validated['password'])) $data['password'] = Hash::make($validated['password']);
        else unset($data['password']);

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /** Delete user (Admin only) */
    public function destroy($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        User::findOrFail($id)->delete();
        return back()->with('success', 'User deleted successfully.');
    }

    /** Approve user (Admin only) */
    public function approve($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        User::findOrFail($id)->update(['is_approved' => true]);
        return back()->with('success', 'User approved.');
    }

    /** Deactivate user (Admin only) */
    public function deactivate($id)
    {
        if (auth()->user()->role !== 'admin') abort(403);

        User::findOrFail($id)->update(['is_approved' => false]);
        return back()->with('success', 'User deactivated.');
    }
}
