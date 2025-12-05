<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Setting;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class ManageSettings extends Component
{
    public $whatsapp_transporter;
    public $whatsapp_agent;
    public $whatsapp_contact;
    public $whatsapp_vehicle_inquiry;
    public $whatsapp_tour_inquiry;

    public function mount()
    {
        $this->whatsapp_transporter = Setting::where('key', 'whatsapp_transporter')->value('value') ?? '';
        $this->whatsapp_agent = Setting::where('key', 'whatsapp_agent')->value('value') ?? '';
        $this->whatsapp_contact = Setting::where('key', 'whatsapp_contact')->value('value') ?? '';
        $this->whatsapp_vehicle_inquiry = Setting::where('key', 'whatsapp_vehicle_inquiry')->value('value') ?? '';
        $this->whatsapp_tour_inquiry = Setting::where('key', 'whatsapp_tour_inquiry')->value('value') ?? '';
    }

    public function save()
    {
        $this->validate([
            'whatsapp_transporter' => 'nullable|string|max:20',
            'whatsapp_agent' => 'nullable|string|max:20',
            'whatsapp_contact' => 'nullable|string|max:20',
            'whatsapp_vehicle_inquiry' => 'nullable|string|max:20',
            'whatsapp_tour_inquiry' => 'nullable|string|max:20',
        ]);

        Setting::updateOrCreate(['key' => 'whatsapp_transporter'], ['value' => $this->whatsapp_transporter]);
        Setting::updateOrCreate(['key' => 'whatsapp_agent'], ['value' => $this->whatsapp_agent]);
        Setting::updateOrCreate(['key' => 'whatsapp_contact'], ['value' => $this->whatsapp_contact]);
        Setting::updateOrCreate(['key' => 'whatsapp_vehicle_inquiry'], ['value' => $this->whatsapp_vehicle_inquiry]);
        Setting::updateOrCreate(['key' => 'whatsapp_tour_inquiry'], ['value' => $this->whatsapp_tour_inquiry]);

        session()->flash('message', 'Settings updated successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-settings');
    }
}
