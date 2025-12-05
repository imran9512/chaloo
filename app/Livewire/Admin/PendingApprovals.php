<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class PendingApprovals extends Component
{
    use WithPagination;

    public function approve($userId)
    {
        $user = User::findOrFail($userId);
        $user->update(['status' => 'active']);

        session()->flash('message', "User {$user->name} has been approved successfully.");
    }

    public function reject($userId)
    {
        // Optional: Add rejection logic (e.g., delete user or set status to rejected)
        $user = User::findOrFail($userId);
        $user->update(['status' => 'suspended']); // Or stay pending with a note?

        session()->flash('error', "User {$user->name} has been rejected/suspended.");
    }

    public function render()
    {
        $pendingUsers = User::where('status', 'pending_approval')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.pending-approvals', [
            'pendingUsers' => $pendingUsers
        ]);
    }
}
