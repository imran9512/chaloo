<?php

namespace App\Livewire\Agent;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Activation extends Component
{
    use WithFileUploads;

    public $id_card_image;
    public $license_image;
    public $submitted = false;

    public function mount()
    {
        $user = Auth::user();
        if ($user->status === 'active') {
            return redirect()->route('agent.dashboard');
        }
        if ($user->status === 'pending_approval') {
            $this->submitted = true;
        }
    }

    public function submit()
    {
        $this->validate([
            'id_card_image' => 'required|image|max:2048', // 2MB Max
            'license_image' => 'required|image|max:2048',
        ]);

        $user = Auth::user();

        $idCardPath = $this->id_card_image->store('documents/id_cards', 'public');
        $licensePath = $this->license_image->store('documents/licenses', 'public');

        $user->update([
            'id_card_image' => $idCardPath,
            'license_image' => $licensePath,
            'status' => 'pending_approval',
        ]);

        $this->submitted = true;
        session()->flash('message', 'Documents submitted successfully! Please contact Admin for approval.');
    }

    public function render()
    {
        return view('livewire.agent.activation');
    }
}
