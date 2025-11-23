<?php

namespace App\Http\Controllers\Transporter;

use App\Http\Controllers\Controller;
use App\Models\CompanyListing;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification; // For admin notify

/**
 * Handles vehicle handover to company with pending approval.
 */
class HandoverController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:transporter');
    }

    /**
     * Handover vehicle: Update status, create listing, notify admin.
     */
    public function handover(Request $request, Vehicle $vehicle)
    {
        $this->authorize('update', $vehicle);

        $request->validate(['markup' => 'required|numeric|min:0']);

        $vehicle->update([
            'managed_by' => 'company',
            'status' => 'pending_handover'
        ]);

        CompanyListing::create([
            'vehicle_id' => $vehicle->id,
            'markup' => $request->markup,
            'admin_approved' => false, // Pending
            'transporter_id' => Auth::id()
        ]);

        // Notify admin (via queue or sync for shared hosting)
        Notification::route('mail', config('admin.email'))->notify(new \App\Notifications\VehicleHandover($vehicle));

        return response()->json(['success' => true, 'message' => 'Vehicle handed over for approval.']);
    }
}