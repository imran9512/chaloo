<?php

namespace App\Livewire\Admin;

use App\Helpers\PermissionHelper;
use App\Models\Permission;
use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ManageStaffPermissions extends Component
{
    public User $user;
    public $selectedPermissions = [];
    public $selectedTemplate = ''; // For permission group templates

    public function mount(User $user)
    {
        // Only allow managing permissions for operators
        if ($user->role !== 'operator') {
            abort(403, 'Can only manage permissions for staff members.');
        }

        // Prevent anyone (even with all rights) from managing admin accounts
        if ($user->role === 'admin') {
            abort(403, 'Cannot manage admin account permissions.');
        }

        $this->user = $user;
        $this->selectedPermissions = PermissionHelper::getPermissions($user);
    }

    public function applyTemplate()
    {
        if (empty($this->selectedTemplate)) {
            return;
        }

        $groups = Permission::permissionGroups();
        if (isset($groups[$this->selectedTemplate])) {
            $this->selectedPermissions = $groups[$this->selectedTemplate]['permissions'];
            session()->flash('message', 'Template applied. You can now customize permissions before saving.');
        }
    }

    public function updatePermissions()
    {
        PermissionHelper::setPermissions($this->user, $this->selectedPermissions);

        session()->flash('message', 'Permissions updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-staff-permissions', [
            'availablePermissions' => Permission::availablePermissions(),
            'permissionGroups' => Permission::permissionGroups(),
        ]);
    }
}
