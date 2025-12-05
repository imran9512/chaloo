<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class CreateStaff extends Component
{
    public $name;
    public $email;
    public $password;
    public $phone;
    public $city;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
        ];
    }

    public function createStaff()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'phone' => $this->phone,
            'city' => $this->city,
            'role' => 'operator',
            'status' => 'active',
        ]);

        session()->flash('message', 'Staff member created successfully.');

        return redirect()->route('admin.users');
    }

    public function render()
    {
        return view('livewire.admin.create-staff');
    }
}
