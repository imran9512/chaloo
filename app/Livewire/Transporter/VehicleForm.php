<?php

namespace App\Livewire\Transporter;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;
use App\Services\ImageOptimizationService;

#[Layout('layouts.app')]
class VehicleForm extends Component
{
    use WithFileUploads;

    public ?Vehicle $vehicle = null;
    public $vehicle_type_id;
    public $name;
    public $brand;
    public $model;
    public $year;
    public $registration_number;
    public $color;
    public $daily_rate; // This is what customer pays (public price)
    public $net_earnings; // This is what transporter receives after commission
    public $driver_fee;
    public $city;
    public $description;
    public $status = 'available';
    public $available_from_date;
    public $features = [];
    public $newImages = [];
    public $temporaryImages = []; // Store newly uploaded images before save
    public $existingImages = [];
    public $featureInput = '';

    public $is_company_managed = false;
    public $commission_percentage = 10.00;

    public function mount(?Vehicle $vehicle = null)
    {
        if ($vehicle && $vehicle->exists) {
            $this->vehicle = $vehicle;

            // Allow admin to edit any vehicle, otherwise check ownership
            if (Auth::user()->role !== 'admin' && $vehicle->user_id !== Auth::id()) {
                abort(403);
            }

            // Populate form fields
            $this->vehicle_type_id = $vehicle->vehicle_type_id;
            $this->name = $vehicle->name;
            $this->brand = $vehicle->brand;
            $this->model = $vehicle->model;
            $this->year = $vehicle->year;
            $this->registration_number = $vehicle->registration_number;
            $this->color = $vehicle->color;
            $this->daily_rate = $vehicle->daily_rate;
            $this->driver_fee = $vehicle->driver_fee;
            $this->city = $vehicle->city;
            $this->description = $vehicle->description;
            $this->status = $vehicle->status;
            $this->available_from_date = $vehicle->available_from_date ? \Carbon\Carbon::parse($vehicle->available_from_date)->format('Y-m-d') : null;
            $this->features = $vehicle->features ?? [];
            $this->existingImages = $vehicle->images ?? [];
            $this->is_company_managed = $vehicle->is_company_managed;
            $this->commission_percentage = $vehicle->commission_percentage;

            // Calculate net earnings
            $this->calculateNetEarnings();
        } else {
            // Check listing limit for new vehicle
            if (Auth::user()->role === 'transporter') {
                $activePackage = \App\Models\UserPackage::where('user_id', Auth::id())
                    ->where('status', 'active')
                    ->first();

                if (!$activePackage || !$activePackage->isActive()) {
                    session()->flash('error', 'No active package found. Please contact admin to get a package.');
                    return redirect()->route('transporter.vehicles');
                }

                $currentCount = Vehicle::where('user_id', Auth::id())->count();
                if ($currentCount >= $activePackage->listing_limit) {
                    session()->flash('error', 'You have reached your listing limit (' . $activePackage->listing_limit . '). Please upgrade your package.');
                    return redirect()->route('transporter.vehicles');
                }
            }
        }
    }

    public function updatedIsCompanyManaged()
    {
        $this->calculateNetEarnings();
    }

    public function updatedDailyRate()
    {
        $this->calculateNetEarnings();
    }

    public function calculateNetEarnings()
    {
        if ($this->is_company_managed && $this->daily_rate) {
            // Deduction method: Customer pays daily_rate, transporter gets (daily_rate - commission)
            $commission = ($this->daily_rate * $this->commission_percentage) / 100;
            $this->net_earnings = $this->daily_rate - $commission;
        } else {
            // If not company managed, transporter gets the full amount
            $this->net_earnings = $this->daily_rate;
        }
    }

    public function addFeature()
    {
        if (!empty($this->featureInput)) {
            $this->features[] = $this->featureInput;
            $this->featureInput = '';
        }
    }

    public function removeFeature($index)
    {
        unset($this->features[$index]);
        $this->features = array_values($this->features);
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
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'color' => 'nullable|string|max:50',
            'daily_rate' => 'required|numeric|min:0',
            'driver_fee' => 'nullable|numeric|min:0',
            'city' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:available,booked,maintenance,available_from_date',
            'available_from_date' => 'nullable|date',
            'features' => 'nullable|array',
            'temporaryImages.*' => 'nullable|image|max:51200', // 50MB max
            'is_company_managed' => 'boolean',
        ]);

        $imagePaths = $this->existingImages;

        // Optimize and convert images to WebP
        if (!empty($this->temporaryImages)) {
            $optimizer = new ImageOptimizationService();
            $optimizedPaths = $optimizer->optimizeMultiple($this->temporaryImages, 'vehicles');
            $imagePaths = array_merge($imagePaths, $optimizedPaths);
        }

        // Recalculate net earnings before saving
        $this->calculateNetEarnings();

        $data = [
            'user_id' => ($this->vehicle && $this->vehicle->exists) ? $this->vehicle->user_id : Auth::id(),
            'vehicle_type_id' => $this->vehicle_type_id,
            'name' => $this->name,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => (int) date('Y'),
            'registration_number' => $this->registration_number,
            'color' => $this->color,
            'daily_rate' => $this->daily_rate, // Customer pays this
            'base_daily_rate' => $this->net_earnings, // Transporter earns this (for reporting)
            'driver_fee' => $this->driver_fee,
            'city' => $this->city,
            'description' => $this->description,
            'status' => $this->status,
            'available_from_date' => $this->status === 'available_from_date' ? $this->available_from_date : null,
            'features' => $this->features,
            'images' => $imagePaths,
            'is_company_managed' => $this->is_company_managed,
            'commission_percentage' => $this->commission_percentage,
        ];

        // If newly handing over to company, mark as unapproved so admin checks it
        if ($this->is_company_managed && (!$this->vehicle || !$this->vehicle->is_company_managed)) {
            $data['is_approved'] = false;
        }

        // If editing an existing company-managed vehicle, mark as unapproved for re-approval
        if ($this->vehicle && $this->vehicle->exists && $this->vehicle->is_company_managed && $this->is_company_managed) {
            $data['is_approved'] = false;
        }

        if ($this->vehicle && $this->vehicle->exists) {
            $this->vehicle->update($data);
            $message = 'Vehicle updated successfully.';

            // Add specific message if it needs re-approval
            if ($this->is_company_managed && !$data['is_approved']) {
                $message .= ' It will be reviewed by admin before appearing on public listings.';
            }
        } else {
            Vehicle::create($data);
            $message = 'Vehicle created successfully.';

            if ($this->is_company_managed) {
                $message .= ' It will be reviewed by admin before appearing on public listings.';
            }
        }

        session()->flash('message', $message);

        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.users.edit', $this->vehicle->user_id);
        }

        return redirect()->route('transporter.vehicles');
    }

    public function render()
    {
        return view('livewire.transporter.vehicle-form', [
            'types' => VehicleType::where('status', true)->get()
        ]);
    }
}
