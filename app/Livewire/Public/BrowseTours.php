<?php

namespace App\Livewire\Public;

use Livewire\Component;
use App\Models\Tour;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.public')]
class BrowseTours extends Component
{
    use WithPagination;

    public $search = '';
    public $minPrice;
    public $maxPrice;
    public $minDays;
    public $maxDays;

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
            $tours = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 12);
            return view('livewire.public.browse-tours', compact('tours'));
        }

        $query = Tour::query()
            ->with(['user'])
            ->whereNotIn('status', ['Deactivate (Hidden)', 'cancelled', 'completed'])
            ->whereHas('user', function ($q) {
                $q->where('role', 'agent')
                    ->where('status', 'active'); // Only show tours from approved agents
            });

        // City Filter (Enhanced)
        // Check if userCity matches EITHER destinations OR departure_city
        $query->where(function ($q) {
            $q->where('destinations', 'like', '%' . $this->userCity . '%')
                ->orWhere('departure_city', 'like', '%' . $this->userCity . '%');
        });

        // Search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('destinations', 'like', '%' . $this->search . '%')
                    ->orWhere('departure_city', 'like', '%' . $this->search . '%');
            });
        }

        // Price filter
        if ($this->minPrice) {
            $query->where('price_per_person', '>=', $this->minPrice);
        }

        if ($this->maxPrice) {
            $query->where('price_per_person', '<=', $this->maxPrice);
        }

        // Duration filter
        if ($this->minDays) {
            $query->where('duration_days', '>=', $this->minDays);
        }

        if ($this->maxDays) {
            $query->where('duration_days', '<=', $this->maxDays);
        }

        $tours = $query->latest()->paginate(12);

        // Debug info
        $totalTours = Tour::count();
        $visibleTours = Tour::whereNotIn('status', ['Deactivate (Hidden)', 'cancelled', 'completed'])->count();
        $activeAgentTours = Tour::whereNotIn('status', ['Deactivate (Hidden)', 'cancelled', 'completed'])
            ->whereHas('user', fn($q) => $q->where('role', 'agent')->where('status', 'active'))
            ->count();

        return view('livewire.public.browse-tours', compact('tours'))
            ->with('debug', [
                'total' => $totalTours,
                'visible' => $visibleTours,
                'active_agent' => $activeAgentTours
            ]);
    }
}
