<?php

namespace App\Livewire\Admin;

use App\Models\VehicleType;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class VehicleTypes extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $capacity, $icon, $status = true;
    public $vehicleTypeId;
    public $isEditMode = false;
    public $showModal = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:vehicle_types,name,' . $this->vehicleTypeId,
            'capacity' => 'required|integer|min:1',
            'icon' => 'nullable|image|max:1024', // 1MB Max
            'status' => 'boolean',
        ];
    }

    public function render()
    {
        $types = VehicleType::orderBy('name')->paginate(10);
        return view('livewire.admin.vehicle-types', ['types' => $types]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->isEditMode = false;
        $this->showModal = true;
    }

    public function edit($id)
    {
        $type = VehicleType::findOrFail($id);
        $this->vehicleTypeId = $id;
        $this->name = $type->name;
        $this->capacity = $type->capacity;
        $this->status = $type->status;
        $this->icon = null; // Don't preload image for upload field

        $this->isEditMode = true;
        $this->showModal = true;
    }

    public function store()
    {
        $validatedData = $this->validate();

        if ($this->icon) {
            $validatedData['icon'] = $this->icon->store('icons', 'public');
        }

        VehicleType::create($validatedData);

        session()->flash('message', 'Vehicle Type Created Successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function update()
    {
        $validatedData = $this->validate();

        $type = VehicleType::find($this->vehicleTypeId);

        if ($this->icon) {
            $validatedData['icon'] = $this->icon->store('icons', 'public');
        } else {
            unset($validatedData['icon']);
        }

        $type->update($validatedData);

        session()->flash('message', 'Vehicle Type Updated Successfully.');
        $this->closeModal();
        $this->resetInputFields();
    }

    public function delete($id)
    {
        VehicleType::find($id)->delete();
        session()->flash('message', 'Vehicle Type Deleted Successfully.');
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    private function resetInputFields()
    {
        $this->name = '';
        $this->capacity = '';
        $this->icon = null;
        $this->status = true;
        $this->vehicleTypeId = null;
    }
}
