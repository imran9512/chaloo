<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleType;
use Illuminate\Http\Request;

/**
 * Admin CRUD for vehicle types.
 * Prevents cascading delete if in use.
 */
class VehicleTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * List with "In Use" count.
     */
    public function index()
    {
        $types = VehicleType::withCount('vehicles')->paginate(10);
        return view('admin.vehicle-types.index', compact('types'));
    }

    /**
     * Store new type.
     */
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:vehicle_types']);

        VehicleType::create($request->only(['name']));

        return redirect()->route('admin.vehicle-types.index')->with('success', 'Type added.');
    }

    /**
     * Update type.
     */
    public function update(Request $request, VehicleType $type)
    {
        $request->validate(['name' => 'required|string|unique:vehicle_types,name,' . $type->id]);

        $type->update($request->only(['name']));

        return back()->with('success', 'Type updated.');
    }

    /**
     * Delete if not in use.
     */
    public function destroy(VehicleType $type)
    {
        if ($type->vehicles_count > 0) {
            return back()->withErrors(['error' => 'Cannot delete: In use by vehicles.']);
        }

        $type->delete();
        return back()->with('success', 'Type deleted.');
    }
}