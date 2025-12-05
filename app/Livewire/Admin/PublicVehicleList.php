<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Vehicle;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class PublicVehicleList extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        // Can delete admin/operator vehicles OR company-managed vehicles
        if (!in_array($vehicle->user->role, ['admin', 'operator']) && !$vehicle->is_company_managed) {
            abort(403);
        }

        $vehicle->delete();
        session()->flash('message', 'Vehicle deleted successfully.');
    }

    public function approve($id)
    {
        $vehicle = Vehicle::findOrFail($id);

        if (!$vehicle->is_company_managed) {
            session()->flash('error', 'Only company-managed vehicles need approval.');
            return;
        }

        $vehicle->is_approved = true;
        $vehicle->save();

        session()->flash('message', 'Vehicle approved successfully.');
    }

    public function updateCommission($id, $commission)
    {
        $vehicle = Vehicle::findOrFail($id);

        if (!$vehicle->is_company_managed) {
            session()->flash('error', 'Commission can only be updated for company-managed vehicles.');
            return;
        }

        $vehicle->commission_percentage = $commission;

        // Recalculate daily_rate based on new commission
        if ($vehicle->base_daily_rate) {
            $commissionAmount = ($vehicle->base_daily_rate * $commission) / 100;
            $vehicle->daily_rate = $vehicle->base_daily_rate + $commissionAmount;
        }

        $vehicle->save();

        session()->flash('message', 'Commission updated successfully.');
    }

    public function updateStatus($id, $status, $date = null)
    {
        $vehicle = Vehicle::findOrFail($id);

        if (!in_array($vehicle->user->role, ['admin', 'operator']) && !$vehicle->is_company_managed) {
            abort(403);
        }

        $vehicle->status = $status;
        if ($status === 'available_from_date' && $date) {
            $vehicle->available_from_date = $date;
        } else {
            $vehicle->available_from_date = null;
        }

        $vehicle->save();
        session()->flash('message', 'Status updated successfully.');
    }

    public function render()
    {
        // List vehicles owned by admin/operator OR company-managed vehicles
        $vehicles = Vehicle::where(function ($query) {
            $query->whereHas('user', function ($q) {
                $q->whereIn('role', ['admin', 'operator']);
            })
                ->orWhere('is_company_managed', true);
        })->with(['user', 'type'])->latest()->paginate(10);

        return view('livewire.admin.public-vehicle-list', compact('vehicles'));
    }
}
