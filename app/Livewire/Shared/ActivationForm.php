<?php

namespace App\Livewire\Shared;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Services\ImageOptimizationService;

class ActivationForm extends Component
{
    use WithFileUploads;

    public $id_card;
    public $id_card_back;
    public $license;
    public $license_back;

    protected $rules = [
        'id_card' => 'required|image|max:51200', // 50MB Max
        'id_card_back' => 'required|image|max:51200',
        'license' => 'required|image|max:51200', // 50MB Max
        'license_back' => 'required|image|max:51200',
    ];

    public function submit()
    {
        $this->validate();

        $user = auth()->user();

        // Optimize and store files as WebP
        $optimizer = new ImageOptimizationService();
        $idCardPath = $optimizer->optimizeAndStore($this->id_card, 'documents/id_cards');
        $idCardBackPath = $optimizer->optimizeAndStore($this->id_card_back, 'documents/id_cards');
        $licensePath = $optimizer->optimizeAndStore($this->license, 'documents/licenses');
        $licenseBackPath = $optimizer->optimizeAndStore($this->license_back, 'documents/licenses');

        // Update user
        $user->update([
            'id_card_image' => $idCardPath,
            'id_card_back_image' => $idCardBackPath,
            'license_image' => $licensePath,
            'license_back_image' => $licenseBackPath,
            'status' => 'pending_approval',
        ]);

        session()->flash('message', 'Documents uploaded successfully! Your account is now pending approval.');

        // Redirect to refresh the dashboard state
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.shared.activation-form');
    }
}
