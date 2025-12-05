<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ManageUsers extends Component
{
    use WithPagination;

    public $activeTab = 'transporters'; // transporters, agents, staff
    public $search = '';

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function suspendUser($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent modifying admin accounts
        if ($user->role === 'admin') {
            session()->flash('error', 'Cannot modify admin accounts.');
            return;
        }

        $user->status = 'suspended';
        $user->save();
        session()->flash('message', 'User suspended successfully.');
    }

    public function activateUser($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent modifying admin accounts
        if ($user->role === 'admin') {
            session()->flash('error', 'Cannot modify admin accounts.');
            return;
        }

        $user->status = 'active';
        $user->save();
        session()->flash('message', 'User activated successfully.');
    }

    public function deleteUser($userId)
    {
        $user = User::findOrFail($userId);

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        // Prevent deleting admin accounts
        if ($user->role === 'admin') {
            session()->flash('error', 'Cannot delete admin accounts.');
            return;
        }

        // Soft delete: just change status to 'deleted'
        $user->status = 'deleted';
        $user->save();

        session()->flash('message', 'User marked as deleted successfully.');
    }

    public function permanentlyDeleteUser($userId)
    {
        // Only admin can permanently delete
        if (auth()->user()->role !== 'admin') {
            session()->flash('error', 'Only admin can permanently delete users.');
            return;
        }

        $user = User::findOrFail($userId);

        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete your own account.');
            return;
        }

        // Prevent deleting admin accounts
        if ($user->role === 'admin') {
            session()->flash('error', 'Cannot delete admin accounts.');
            return;
        }

        $user->delete();
        session()->flash('message', 'User permanently deleted successfully.');
    }

    public function render()
    {
        $query = User::query();

        if ($this->activeTab === 'transporters') {
            $query->where('role', 'transporter');
        } elseif ($this->activeTab === 'agents') {
            $query->where('role', 'agent');
        } elseif ($this->activeTab === 'staff') {
            $query->where('role', 'operator');
        }

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%')
                    ->orWhere('phone', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->latest()->paginate(15);

        return view('livewire.admin.manage-users', [
            'users' => $users
        ]);
    }
}
