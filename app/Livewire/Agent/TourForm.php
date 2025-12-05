<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use App\Models\Tour;
use App\Models\UserPackage;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Attributes\Layout;
use App\Services\ImageOptimizationService;

#[Layout('layouts.app')]
class TourForm extends Component
{
    use WithFileUploads;

    public ?Tour $tour = null;

    public $company_name;
    public $name;
    public $departure_city;
    public $destinations = [['city' => '', 'order' => 1, 'special_notes' => '']];
    public $departure_date;
    public $arrival_date;
    public $duration_days = 0;
    public $price_per_person;
    public $price_per_couple;
    public $description;
    public $status = 'booking_on';

    // Add-ons
    public $meals_included = false;
    public $meals_price;
    public $individual_room_price;
    public $site_visits = []; // [{name, price}]
    public $custom_addons = []; // [{name, price}]

    public $existingImages = [];
    public $newImages = [];
    public $temporaryImages = []; // Store newly uploaded images before save

    public function mount(Tour $tour = null)
    {
        if ($tour && $tour->exists) {
            $this->tour = $tour;
            $this->company_name = $tour->company_name;
            $this->name = $tour->name;
            $this->departure_city = $tour->departure_city;
            $this->destinations = $tour->destinations ?? [['city' => '', 'order' => 1, 'special_notes' => '']];
            $this->departure_date = $tour->departure_date ? \Carbon\Carbon::parse($tour->departure_date)->format('Y-m-d') : null;
            $this->arrival_date = $tour->arrival_date ? \Carbon\Carbon::parse($tour->arrival_date)->format('Y-m-d') : null;
            $this->duration_days = $tour->duration_days;
            $this->price_per_person = $tour->price_per_person;
            $this->price_per_couple = $tour->price_per_couple;
            $this->description = $tour->description;
            $this->status = $tour->status;
            $this->existingImages = $tour->images ?? [];

            // Load add-ons
            $addons = $tour->optional_addons ?? [];
            $this->meals_included = $addons['meals']['included'] ?? false;
            $this->meals_price = $addons['meals']['price'] ?? null;
            $this->individual_room_price = $addons['individual_room']['price'] ?? null;
            $this->site_visits = $addons['site_visits'] ?? [];
            $this->custom_addons = $addons['custom_addons'] ?? [];
        } else {
            $this->company_name = Auth::user()->name;

            // Check listing limit for new tour
            $activePackage = UserPackage::where('user_id', Auth::id())
                ->where('status', 'active')
                ->first();

            if (!$activePackage || !$activePackage->isActive()) {
                session()->flash('error', 'You need an active package to list tours.');
                return redirect()->route('agent.buy-packages');
            }

            $currentListings = Auth::user()->tours()->count();
            if ($currentListings >= $activePackage->listing_limit) {
                session()->flash('error', 'Listing limit reached. Please upgrade your package.');
                return redirect()->route('agent.dashboard');
            }
        }
    }

    public function updatedDepartureDate()
    {
        $this->calculateDuration();
    }

    public function updatedArrivalDate()
    {
        $this->calculateDuration();
    }

    public function calculateDuration()
    {
        if ($this->departure_date && $this->arrival_date) {
            $start = \Carbon\Carbon::parse($this->departure_date);
            $end = \Carbon\Carbon::parse($this->arrival_date);
            if ($end->gte($start)) {
                $this->duration_days = $start->diffInDays($end) + 1; // Including start date
            } else {
                $this->duration_days = 0;
            }
        }
    }

    public function addDestination()
    {
        $this->destinations[] = ['city' => '', 'order' => count($this->destinations) + 1, 'special_notes' => ''];
    }

    public function removeDestination($index)
    {
        unset($this->destinations[$index]);
        $this->destinations = array_values($this->destinations);
    }

    public function addSiteVisit()
    {
        $this->site_visits[] = ['name' => '', 'price' => ''];
    }

    public function removeSiteVisit($index)
    {
        unset($this->site_visits[$index]);
        $this->site_visits = array_values($this->site_visits);
    }

    public function addCustomAddon()
    {
        $this->custom_addons[] = ['name' => '', 'price' => ''];
    }

    public function removeCustomAddon($index)
    {
        unset($this->custom_addons[$index]);
        $this->custom_addons = array_values($this->custom_addons);
    }

    public function removeImage($index)
    {
        unset($this->existingImages[$index]);
        $this->existingImages = array_values($this->existingImages);
    }

    public function removeTemporaryImage($index)
    {
        unset($this->temporaryImages[$index]);
        $this->temporaryImages = array_values($this->temporaryImages);
    }

    public function updatedNewImages()
    {
        // When new images are selected, add them to temporary array
        if ($this->newImages) {
            foreach ($this->newImages as $image) {
                $this->temporaryImages[] = $image;
            }
            // Reset newImages to allow adding more
            $this->newImages = [];
        }
    }

    public function save()
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'departure_city' => 'required|string|max:255',
            'destinations' => 'required|array|min:1',
            'destinations.*.city' => 'required|string',
            'departure_date' => 'required|date',
            'arrival_date' => 'required|date|after_or_equal:departure_date',
            'price_per_person' => 'required|numeric|min:0',
            'price_per_couple' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'temporaryImages.*' => 'nullable|image|max:51200', // 50MB max
            'temporaryImages' => 'max:10', // Max 10 images
        ]);

        $imagePaths = $this->existingImages;

        // Optimize and convert images to WebP
        if (!empty($this->temporaryImages)) {
            $optimizer = new ImageOptimizationService();
            $optimizedPaths = $optimizer->optimizeMultiple($this->temporaryImages, 'tours');
            $imagePaths = array_merge($imagePaths, $optimizedPaths);
        }

        $addons = [
            'meals' => [
                'included' => $this->meals_included,
                'price' => $this->meals_price
            ],
            'individual_room' => [
                'price' => $this->individual_room_price
            ],
            'site_visits' => $this->site_visits,
            'custom_addons' => $this->custom_addons
        ];

        $data = [
            'user_id' => Auth::id(),
            'company_name' => $this->company_name,
            'name' => $this->name,
            'departure_city' => $this->departure_city,
            'destinations' => $this->destinations,
            'departure_date' => $this->departure_date,
            'arrival_date' => $this->arrival_date,
            'duration_days' => $this->duration_days,
            'price_per_person' => $this->price_per_person,
            'price_per_couple' => $this->price_per_couple,
            'description' => $this->description,
            'status' => $this->status,
            'images' => $imagePaths,
            'optional_addons' => $addons,
        ];

        if ($this->tour) {
            $this->tour->update($data);
            session()->flash('message', 'Tour updated successfully.');
        } else {
            Tour::create($data);
            session()->flash('message', 'Tour created successfully.');
        }

        return redirect()->route('agent.tours');
    }

    public function render()
    {
        return view('livewire.agent.tour-form');
    }
}
