<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Package;
use App\Models\UserPackage;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Carbon\Carbon;

#[Layout('layouts.app')]
class AssignPackage extends Component
{
    public User $user;
    public $package_id = '';
    public $is_custom = false;
    public $listing_limit;
    public $price_paid;
    public $duration_days;
    public $started_at;
    public $expires_at;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->started_at = now()->format('Y-m-d');
    }

    public function updatedPackageId($value)
    {
        if ($value && !$this->is_custom) {
            $package = Package::find($value);
            if ($package) {
                $this->listing_limit = $package->listing_limit;
                $this->price_paid = $package->price;
                $this->duration_days = $package->duration_days;
                $this->calculateExpiry();
            }
        }
    }

    public function updatedStartedAt()
    {
        $this->calculateExpiry();
    }

    public function updatedDurationDays()
    {
        $this->calculateExpiry();
    }

    public function calculateExpiry()
    {
        if ($this->started_at && $this->duration_days) {
            $this->expires_at = Carbon::parse($this->started_at)
                ->addDays((int) $this->duration_days)
                ->format('Y-m-d');
        }
    }

    public function assignPackage()
    {
        $this->validate([
            'listing_limit' => 'required|integer|min:1',
            'price_paid' => 'required|numeric|min:0',
            'started_at' => 'required|date',
            'expires_at' => 'required|date|after:started_at',
        ]);

        // Deactivate existing active packages
        UserPackage::where('user_id', $this->user->id)
            ->where('status', 'active')
            ->update(['status' => 'cancelled']);

        // Create new package
        UserPackage::create([
            'user_id' => $this->user->id,
            'package_id' => $this->is_custom ? null : $this->package_id,
            'is_custom' => $this->is_custom,
            'listing_limit' => $this->listing_limit,
            'price_paid' => $this->price_paid,
            'started_at' => $this->started_at,
            'expires_at' => $this->expires_at,
            'status' => 'active',
        ]);

        session()->flash('message', 'Package assigned successfully.');
        return redirect()->route('admin.users.edit', $this->user->id);
    }

    public function render()
    {
        $packages = Package::where('type', $this->user->role)
            ->where('is_active', true)
            ->get();

        $currentPackage = UserPackage::where('user_id', $this->user->id)
            ->where('status', 'active')
            ->first();

        $packageHistory = UserPackage::where('user_id', $this->user->id)
            ->with('package')
            ->latest()
            ->get();

        return view('livewire.admin.assign-package', [
            'packages' => $packages,
            'currentPackage' => $currentPackage,
            'packageHistory' => $packageHistory,
        ]);
    }
}
