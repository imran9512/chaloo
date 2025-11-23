<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

/**
 * Admin user inspection and actions.
 */
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin,operator'); // Role-based
    }

    /**
     * Show user detail with tabs: Profile, Vehicles, Subscriptions, Activity.
     */
    public function show(User $user)
    {
        $profile = $user;
        $vehicles = $user->vehicles()->paginate(5); // Inline edit modal
        $subscriptions = $user->subscriptions()->orderBy('created_at')->get(); // Timeline
        $activity = $user->activityLogs()->latest()->take(10)->get(); // Assuming logs table

        return view('admin.users.show', compact('user', 'profile', 'vehicles', 'subscriptions', 'activity'));
    }

    /**
     * Quick actions: Activate/suspend, change plan.
     */
    public function quickAction(Request $request, User $user)
    {
        $request->validate(['action' => 'required|in:activate,suspend,change_plan']);

        switch ($request->action) {
            case 'activate':
                $user->update(['status' => 'active']);
                break;
            case 'suspend':
                $user->update(['status' => 'suspended']);
                break;
            case 'change_plan':
                $user->update(['plan' => $request->new_plan]);
                break;
        }

        return back()->with('success', "User {$request->action}d.");
    }
}