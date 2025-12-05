<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use App\Models\Tour;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class TourList extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $tour = Tour::where('user_id', Auth::id())->findOrFail($id);
        $tour->delete();
        session()->flash('message', 'Tour deleted successfully.');
    }

    public function updateStatus($tourId, $status)
    {
        $tour = Tour::where('user_id', Auth::id())->findOrFail($tourId);

        $validStatuses = ['booking_on', 'booking_off', 'deactivated'];

        if (in_array($status, $validStatuses)) {
            $tour->update(['status' => $status]);
            session()->flash('message', 'Tour status updated to ' . ucfirst(str_replace('_', ' ', $status)));
        }
    }

    public function render()
    {
        $tours = Tour::where('user_id', Auth::id())->latest()->paginate(10);
        return view('livewire.agent.tour-list', compact('tours'));
    }
}
