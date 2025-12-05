<?php

namespace App\Livewire\Admin;

use App\Models\Package;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ManagePackages extends Component
{
    public $packages;
    public $name, $type, $listing_limit, $price, $duration_days, $features = [];
    public $editingId = null;
    public $showForm = false;

    public function mount()
    {
        $this->loadPackages();
    }

    public function loadPackages()
    {
        $this->packages = Package::latest()->get();
    }

    public function create()
    {
        $this->resetForm();
        $this->showForm = true;
    }

    public function edit($id)
    {
        $package = Package::findOrFail($id);
        $this->editingId = $package->id;
        $this->name = $package->name;
        $this->type = $package->type;
        $this->listing_limit = $package->listing_limit;
        $this->price = $package->price;
        $this->duration_days = $package->duration_days;
        $this->features = $package->features ?? [];
        $this->showForm = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:transporter,agent',
            'listing_limit' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
        ]);

        $data = [
            'name' => $this->name,
            'type' => $this->type,
            'listing_limit' => $this->listing_limit,
            'price' => $this->price,
            'duration_days' => $this->duration_days,
            'features' => $this->features,
        ];

        if ($this->editingId) {
            Package::find($this->editingId)->update($data);
            session()->flash('message', 'Package updated successfully.');
        } else {
            Package::create($data);
            session()->flash('message', 'Package created successfully.');
        }

        $this->resetForm();
        $this->loadPackages();
    }

    public function delete($id)
    {
        Package::findOrFail($id)->delete();
        session()->flash('message', 'Package deleted successfully.');
        $this->loadPackages();
    }

    public function toggleStatus($id)
    {
        $package = Package::findOrFail($id);
        $package->update(['is_active' => !$package->is_active]);
        $this->loadPackages();
    }

    public function resetForm()
    {
        $this->editingId = null;
        $this->name = '';
        $this->type = 'transporter';
        $this->listing_limit = '';
        $this->price = '';
        $this->duration_days = '';
        $this->features = [];
        $this->showForm = false;
    }

    public function render()
    {
        return view('livewire.admin.manage-packages');
    }
}
