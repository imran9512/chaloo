<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

#[Layout('layouts.app')]
class PublicVehicleForm extends Component
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
    public $daily_rate;
    public $driver_fee;
    public $city;
    public $description;
    public $status = 'available';
    public $available_from_date;
    public $features = [];
    public $newImages = [];
    public $existingImages = [];
    public $featureInput = '';

    public function mount(?Vehicle $vehicle = null)
    {
        if ($vehicle && $vehicle->exists) {
            $this->vehicle = $vehicle;

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
        } else {
            // Defaults
            $this->year = date('Y');
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
            'newImages.*' => 'nullable|image|max:2048',
        ]);

        $imagePaths = $this->existingImages;

        foreach ($this->newImages as $image) {
            $imagePaths[] = $image->store('vehicles', 'public');
        }

        $data = [
            'user_id' => ($this->vehicle && $this->vehicle->exists) ? $this->vehicle->user_id : Auth::id(),
            'vehicle_type_id' => $this->vehicle_type_id,
            'name' => $this->name,
            'brand' => $this->brand,
            'model' => $this->model,
            'year' => $this->year,
            'registration_number' => $this->registration_number,
            'color' => $this->color,
            'daily_rate' => $this->daily_rate,
            'driver_fee' => $this->driver_fee,
            'city' => $this->city,
            'description' => $this->description,
            'status' => $this->status,
            'available_from_date' => $this->status === 'available_from_date' ? $this->available_from_date : null,
            'features' => $this->features,
            'images' => $imagePaths,
            'is_approved' => true, // Admin vehicles are auto-approved
        ];

        if ($this->vehicle && $this->vehicle->exists) {
            $this->vehicle->update($data);
            $message = 'Vehicle updated successfully.';
        } else {
            Vehicle::create($data);
            $message = 'Vehicle created successfully.';
        }

        session()->flash('message', $message);

        return redirect()->route('admin.vehicles');
    }

    public function render()
    {
        return view('livewire.admin.public-vehicle-form', [
            'types' => VehicleType::where('status', true)->get()
        ]);
    }
}
