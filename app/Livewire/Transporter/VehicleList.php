<?php

namespace App\Livewire\Transporter;

use Livewire\Component;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class VehicleList extends Component
{
    public function render()
    {
        $vehicles = Vehicle::where('user_id', Auth::id())->latest()->paginate(10);
        return view('livewire.transporter.vehicle-list', compact('vehicles'));
    }
}
