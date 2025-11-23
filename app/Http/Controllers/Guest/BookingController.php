<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\CompanyListing;
use App\Models\GuestLead;
use Illuminate\Http\Request;

/**
 * Guest B2C flow: Leads and public vehicle views.
 */
class GuestBookingController extends Controller
{
    /**
     * Capture lead: Store in session and DB.
     */
    public function storeLead(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100'
        ]);

        $lead = GuestLead::create($request->only(['name', 'phone', 'city']));

        // Store in session for flow continuity
        session(['guest_lead_id' => $lead->id]);

        return redirect()->route('guest.vehicles')->with('success', 'Lead captured. Explore vehicles!');
    }

    /**
     * Public vehicle list: Only approved company vehicles.
     */
    public function vehicles()
    {
        $vehicles = CompanyListing::with('vehicle.type', 'vehicle.photos')
            ->where('admin_approved', true)
            ->paginate(12);

        return view('guest.vehicles.index', compact('vehicles'));
    }

    /**
     * Public vehicle detail with SEO schema.
     */
    public function show($id, $slug)
    {
        $vehicle = CompanyListing::with('vehicle')->where('vehicle_id', $id)->whereHas('vehicle', fn($q) => $q->where('slug', $slug))->firstOrFail();

        // SEO: Set meta in view (e.g., title: "{$vehicle->vehicle->name} for rent in {$vehicle->vehicle->city} - Chaloo")
        return view('guest.vehicles.show', compact('vehicle'));
    }
}