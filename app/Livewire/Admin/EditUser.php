<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Tour;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class EditUser extends Component
{
    use WithPagination;

    public User $user;
    public $name, $email, $phone, $city, $company_name, $status;
    public $new_password; // For password reset
    public $activeTab = 'details'; // details, vehicles, tours

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->phone = $user->phone;
        $this->city = $user->city;
        $this->company_name = $user->company_name;
        $this->status = $user->status;
    }

    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->resetPage();
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:20',
            'city' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'status' => 'required|in:active,suspended,pending_approval',
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'city' => $this->city,
            'company_name' => $this->company_name,
            'status' => $this->status,
        ]);

        session()->flash('message', 'User updated successfully.');
    }

    public function deleteVehicle($vehicleId)
    {
        $vehicle = Vehicle::where('user_id', $this->user->id)->findOrFail($vehicleId);
        $vehicle->delete();
        session()->flash('message', 'Vehicle deleted successfully.');
    }

    public function deleteTour($tourId)
    {
        $tour = Tour::where('user_id', $this->user->id)->findOrFail($tourId);
        $tour->delete();
        session()->flash('message', 'Tour deleted successfully.');
    }

    public function updateVehicleStatus($vehicleId, $status, $date = null)
    {
        $vehicle = Vehicle::where('user_id', $this->user->id)->findOrFail($vehicleId);
        $vehicle->status = $status;
        $vehicle->available_from_date = $status === 'available_from_date' ? $date : null;
        $vehicle->save();

        session()->flash('message', 'Vehicle status updated successfully.');
    }

    public function resetPassword()
    {
        $this->validate([
            'new_password' => 'required|string|min:8',
        ]);

        $this->user->update([
            'password' => \Hash::make($this->new_password),
        ]);

        $this->new_password = '';
        session()->flash('message', 'Password reset successfully.');
    }

    public function render()
    {
        $vehicles = [];
        $tours = [];

        if ($this->user->role === 'transporter') {
            $vehicles = Vehicle::where('user_id', $this->user->id)
                ->with('type')
                ->latest()
                ->paginate(10);
        }

        if ($this->user->role === 'agent') {
            $tours = Tour::where('user_id', $this->user->id)
                ->latest()
                ->paginate(10);
        }

        return view('livewire.admin.edit-user', [
            'vehicles' => $vehicles,
            'tours' => $tours,
        ]);
    }
}
