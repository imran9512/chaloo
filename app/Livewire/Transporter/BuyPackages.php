<?php

namespace App\Livewire\Transporter;

use Livewire\Component;
use App\Models\Package;
use App\Models\UserPackage;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Carbon\Carbon;

#[Layout('layouts.app')]
class BuyPackages extends Component
{
    public function purchasePackage($packageId)
    {
        $package = Package::findOrFail($packageId);
        $user = Auth::user();

        // Deactivate any existing active packages
        UserPackage::where('user_id', $user->id)
            ->where('status', 'active')
            ->update(['status' => 'expired']);

        $startDate = Carbon::now();
        $expiryDate = $startDate->copy()->addDays($package->duration_days);

        if ($package->price == 0) {
            // Free package - Auto activate
            UserPackage::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'listing_limit' => $package->listing_limit,
                'price_paid' => 0,
                'started_at' => $startDate,
                'expires_at' => $expiryDate,
                'status' => 'active',
                'payment_status' => 'free',
                'purchased_at' => now(),
            ]);

            session()->flash('message', 'Free package activated successfully! You can now create listings.');
            return redirect()->route($user->role . '.dashboard');
        } else {
            // Paid package - Create pending package
            UserPackage::create([
                'user_id' => $user->id,
                'package_id' => $package->id,
                'listing_limit' => $package->listing_limit,
                'price_paid' => $package->price,
                'started_at' => $startDate,
                'expires_at' => $expiryDate,
                'status' => 'pending',
                'payment_status' => 'pending',
                'purchased_at' => now(),
            ]);

            // Get WhatsApp number based on user role
            $whatsappKey = $user->role === 'transporter' ? 'whatsapp_transporter' : 'whatsapp_agent';
            $whatsappNumber = Setting::where('key', $whatsappKey)->value('value') ?? '+923001234567';

            $message = "Hi, I want to purchase *{$package->name}* package for *PKR " . number_format((float) $package->price) . "*\n\n";
            $message .= "User: {$user->name}\n";
            $message .= "Email: {$user->email}\n";
            $message .= "Phone: {$user->phone}";

            $whatsappUrl = 'https://wa.me/' . str_replace(['+', ' ', '-'], '', $whatsappNumber) . '?text=' . urlencode($message);

            session()->flash('whatsapp_url', $whatsappUrl);
            session()->flash('package_name', $package->name);
            return redirect()->route($user->role . '.buy-packages');
        }
    }

    public function render()
    {
        $userRole = Auth::user()->role;
        $packages = Package::where('type', $userRole)->get();
        return view('livewire.transporter.buy-packages', compact('packages'));
    }
}
