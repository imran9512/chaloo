<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class BrowseVehicles extends Component
{
    use WithPagination;

    public $search = '';
    public $typeId = '';
    public $minPrice;
    public $maxPrice;

    public $userCity;
    public $showCityModal = false;

    public function mount()
    {
        $this->userCity = session('user_city');
        if (!$this->userCity) {
            $this->showCityModal = true;
        }
    }

    public function setCity($city = null)
    {
        $city = $city ?? $this->userCity;

        if (!empty($city)) {
            session(['user_city' => $city]);
            $this->userCity = $city;
            $this->showCityModal = false;
            $this->resetPage();
        }
    }

    public function changeCity()
    {
        session()->forget('user_city');
        $this->userCity = null;
        $this->showCityModal = true;
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedTypeId()
    {
        $this->resetPage();
    }

    public function updatedMinPrice()
    {
        $this->resetPage();
    }

    public function updatedMaxPrice()
    {
        $this->resetPage();
    }

    public function render()
    {
        // If no city is selected, return empty result to save server load
        if (!$this->userCity) {
            $vehicles = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12);
            $types = collect([]);
            return view('livewire.public.browse-vehicles', compact('vehicles', 'types'));
        }

        $query = Vehicle::query()
            ->with(['user', 'type'])
            ->where('status', 'available')
            ->where('is_approved', true) // Only approved vehicles
            ->where(function ($q) {
                // Admin/Operator owned vehicles OR approved company-managed vehicles
                $q->whereHas('user', function ($userQuery) {
                    $userQuery->whereIn('role', ['admin', 'operator']);
                })
                    ->orWhere(function ($managedQuery) {
                    $managedQuery->where('is_company_managed', true)
                        ->whereHas('user', function ($transporterQuery) {
                            $transporterQuery->where('role', 'transporter')
                                ->where('status', 'active');
                        });
                });
            });

        // City Filter (Mandatory)
        $query->where('city', $this->userCity);

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('brand', 'like', '%' . $this->search . '%')
                    ->orWhere('model', 'like', '%' . $this->search . '%')
                    ->orWhere('city', 'like', '%' . $this->search . '%');
            });
        }

        // Type filter
        if ($this->typeId) {
            $query->where('vehicle_type_id', $this->typeId);
        }

        // Price filter
        if ($this->minPrice) {
            $query->where('daily_rate', '>=', $this->minPrice);
        }

        if ($this->maxPrice) {
            $query->where('daily_rate', '<=', $this->maxPrice);
        }

        // Sort: Company-owned first, then managed vehicles
        $vehicles = $query->orderByRaw('
            CASE 
                WHEN EXISTS (SELECT 1 FROM users WHERE users.id = vehicles.user_id AND users.role IN ("admin", "operator")) THEN 1
                ELSE 2
            END
        ')->latest()->paginate(12);

        $types = VehicleType::where('status', true)->get();

        return view('livewire.public.browse-vehicles', compact('vehicles', 'types'));
    }
}
