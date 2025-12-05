<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class SearchVehicles extends Component
{
    use WithPagination;

    public $city;
    public $selectedType;
    public $dateFrom;
    public $dateTo;

    public function updatedCity()
    {
        $this->resetPage();
    }

    public function updatedSelectedType()
    {
        $this->resetPage();
    }

    public function render()
    {
        // Get unique cities for dropdown (only from transporter vehicles)
        $cities = Vehicle::whereHas('user', function ($q) {
            $q->where('role', 'transporter')->where('status', 'active');
        })
            ->where('is_company_managed', false) // Exclude company-managed
            ->select('city')->distinct()->orderBy('city')->pluck('city');

        $vehicleTypes = VehicleType::all();

        $query = Vehicle::query()
            ->with(['type', 'user'])
            ->where('status', 'available')
            ->where('is_company_managed', false); // CRITICAL: Exclude company-managed vehicles

        // Only show vehicles from active transporters
        $query->whereHas('user', function ($q) {
            $q->where('role', 'transporter')
                ->where('status', 'active');
        });

        // Filter by City
        if ($this->city) {
            $query->where('city', $this->city);
        }

        // Filter by Type
        if ($this->selectedType) {
            $query->where('vehicle_type_id', $this->selectedType);
        }

        // Filter by Date (Basic availability check)
        if ($this->dateFrom) {
            $query->where(function ($q) {
                $q->whereNull('available_from_date')
                    ->orWhere('available_from_date', '<=', $this->dateFrom);
            });
        }

        $vehicles = $query->latest()->paginate(12);

        return view('livewire.agent.search-vehicles', compact('vehicles', 'cities', 'vehicleTypes'));
    }
}
