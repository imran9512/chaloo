<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\CompanyListing;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Agent-specific company vehicle listings.
 * Shows only admin-approved; excludes from general search.
 */
class CompanyListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Display paginated approved company vehicles with filters.
     */
    public function index(Request $request)
    {
        $query = CompanyListing::with(['vehicle.type', 'vehicle.photos'])
            ->where('admin_approved', true)
            ->join('vehicles', 'company_listings.vehicle_id', '=', 'vehicles.id');

        // Filters (similar to search but company-only)
        $query->when($request->vehicle_type_id, fn($q) => $q->where('vehicles.vehicle_type_id', $request->vehicle_type_id))
              ->when($request->city, fn($q) => $q->where('vehicles.city', 'like', '%' . $request->city . '%'))
              ->when($request->rate_min, fn($q) => $q->where('vehicles.total_rate', '>=', $request->rate_min))
              ->when($request->rate_max, fn($q) => $q->where('vehicles.total_rate', '<=', $request->rate_max));

        $listings = $query->orderBy('vehicles.created_at', 'desc')->paginate(12);

        // Types for filter dropdown
        $types = VehicleType::all(['id', 'name']);

        return view('agent.company-listings.index', compact('listings', 'types'));
    }

    /**
     * Show single listing detail (inquiry form).
     */
    public function show(CompanyListing $listing)
    {
        if (!$listing->admin_approved) {
            abort(404);
        }

        $vehicle = $listing->vehicle->load('photos', 'type');
        return view('agent.company-listings.show', compact('listing', 'vehicle'));
    }

    /**
     * Quick inquiry from listing (logs to inquiries table).
     */
    public function inquire(Request $request, CompanyListing $listing)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'preferred_date' => 'nullable|date'
        ]);

        $inquiry = $listing->vehicle->inquiries()->create([
            'agent_id' => Auth::id(),
            'message' => $request->message,
            'preferred_date' => $request->preferred_date,
            'status' => 'new'
        ]);

        // Notify company/admin
        $listing->vehicle->user->notify(new \App\Notifications\NewInquiry($inquiry));

        return back()->with('success', 'Inquiry sent. Await response.');
    }
}