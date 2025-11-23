<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;

/**
 * Agent search and filtering with rate sorting.
 * Excludes company-managed vehicles unless specified.
 */
class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Handle search: Build query with filters, return JSON for AJAX.
     */
    public function search(Request $request)
    {
        $query = Vehicle::with('type', 'photos')
            ->where('status', 'active')
            ->where('managed_by', '!=', 'company'); // Exclusion rule

        // Filters
        $query->when($request->vehicle_type_id, fn($q) => $q->where('vehicle_type_id', $request->vehicle_type_id))
              ->when($request->city, fn($q) => $q->where('city', 'like', '%' . $request->city . '%'))
              ->when($request->date_range, function($q) use ($request) {
                  [$start, $end] = explode(' to ', $request->date_range);
                  $q->whereBetween('available_from', [$start, $end]);
              })
              ->when($request->seats_min, fn($q) => $q->where('seats', '>=', $request->seats_min))
              ->when($request->seats_max, fn($q) => $q->where('seats', '<=', $request->seats_max))
              ->when($request->rate_min, fn($q) => $q->where('total_rate', '>=', $request->rate_min))
              ->when($request->rate_max, fn($q) => $q->where('total_rate', '<=', $request->rate_max));

        // Rate sorting (total_rate = base_rate + driver_rate)
        $query->when($request->sort_by === 'rate_asc', fn($q) => $q->orderBy('total_rate', 'asc'))
              ->when($request->sort_by === 'rate_desc', fn($q) => $q->orderBy('total_rate', 'desc'))
              ->orderBy('created_at', 'desc');

        $vehicles = $query->paginate(12);

        if ($request->ajax()) {
            return response()->json($vehicles);
        }

        return view('agent.search.results', compact('vehicles'));
    }

    /**
     * Company listings only (approved).
     */
    public function companyListings()
    {
        $vehicles = Vehicle::with('type', 'photos')
            ->join('company_listings', 'vehicles.id', '=', 'company_listings.vehicle_id')
            ->where('company_listings.admin_approved', true)
            ->paginate(12);

        return view('agent.company-listings', compact('vehicles'));
    }
}