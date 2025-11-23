<?php

namespace App\Http\Controllers\Transporter;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Services\ImageService;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    protected $imageService;

    // Correct way in Laravel 9+ (service injection + middleware)
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService;
        // $this->middleware('auth:transporter');
    }

    public function index()
    {
        $vehicles = auth('transporter')->user()->vehicles()->with('photos')->get();
        $types = VehicleType::all();
        return view('transporter.dashboard', compact('vehicles', 'types'));
    }

    public function create()
    {
        $types = VehicleType::all();
        return view('transporter.vehicles.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'city'            => 'required|string|max:100',
            'seats'           => 'required|integer|min:1',
            'base_rate'       => 'required|numeric|min:0',
            'driver_rate'     => 'nullable|numeric|min:0',
            'special_note'    => 'nullable|string|max:1000',
            'photos.*'        => 'required|image|mimes:jpeg,png,jpg|max:20480'
        ]);

        $limit = auth('transporter')->user()->listing_limit ?? 10;
        if (auth('transporter')->user()->vehicles()->count() >= $limit) {
            return back()->withErrors(['limit' => "Max {$limit} vehicles allowed."]);
        }

        $vehicle = auth('transporter')->user()->vehicles()->create([
            'name'            => $request->name,
            'vehicle_type_id' => $request->vehicle_type_id,
            'city'            => $request->city,
            'seats'           => $request->seats,
            'base_rate'       => $request->base_rate,
            'driver_rate'     => $request->driver_rate,
            'special_note'    => $request->special_note,
            'status'          => 'active',
            'managed_by'      => 'transporter'
        ]);

        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $index => $photo) {
                $path = $this->imageService->optimizeAndStore($photo, 'vehicles');
                $vehicle->photos()->create([
                    'path'       => $path,
                    'sort_order' => $index + 1,
                    'is_primary' => $index === 0
                ]);
            }
        }

        return redirect()->route('transporter.dashboard')
                         ->with('success', 'Vehicle added successfully!');
    }
}