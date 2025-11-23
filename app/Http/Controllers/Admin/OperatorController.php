<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * Admin operator management with permissions.
 * Super admin only for create/edit.
 */
class OperatorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:super_admin'); // Exclusive guard
    }

    /**
     * List operators.
     */
    public function index()
    {
        $operators = User::where('role', 'operator')->paginate(10);
        return view('admin.operators.index', compact('operators'));
    }

    /**
     * Create operator with permissions.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
            'permissions.*' => 'boolean' // e.g., can_manage_transporters
        ]);

        $user = User::create(array_merge($request->only(['name', 'email']), [
            'password' => Hash::make($request->password),
            'role' => 'operator'
        ]));

        // Assign permissions (boolean columns)
        foreach (['can_manage_transporters', 'can_manage_agents', 'can_manage_payments', 'can_manage_vehicle_types', 'can_manage_settings'] as $perm) {
            $user->{$perm} = $request->{$perm} ?? false;
        }
        $user->save();

        return redirect()->route('admin.operators.index')->with('success', 'Operator created.');
    }

    /**
     * Update permissions (no super_admin edits).
     */
    public function update(Request $request, User $user)
    {
        if ($user->role === 'super_admin') {
            abort(403);
        }

        $request->validate(['permissions.*' => 'boolean']);

        foreach (['can_manage_transporters', 'can_manage_agents', 'can_manage_payments', 'can_manage_vehicle_types', 'can_manage_settings'] as $perm) {
            $user->{$perm} = $request->{$perm} ?? false;
        }
        $user->save();

        return back()->with('success', 'Permissions updated.');
    }
}