<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Favorite;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Favorites system: Toggle and list.
 */
class FavoriteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Toggle favorite: AJAX endpoint.
     */
    public function toggle(Request $request, Vehicle $vehicle)
    {
        $favorite = Favorite::firstOrCreate([
            'agent_id' => Auth::id(),
            'vehicle_id' => $vehicle->id
        ]);

        if ($request->action === 'remove') {
            $favorite->delete();
            return response()->json(['status' => 'removed']);
        }

        return response()->json(['status' => 'added']);
    }

    /**
     * List favorites with real-time status.
     */
    public function index()
    {
        $favorites = Auth::user()->favorites()->with('vehicle')->paginate(12);
        return view('agent.favorites.index', compact('favorites'));
    }
}