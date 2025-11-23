<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Notification system: Poll for updates.
 */
class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:agent');
    }

    /**
     * Get unread count and recent notifications (AJAX poll).
     */
    public function poll()
    {
        $unreadCount = Auth::user()->notifications()->unread()->count();
        $recent = Auth::user()->notifications()
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'unread_count' => $unreadCount,
            'recent' => $recent
        ]);
    }

    /**
     * Mark as read on dropdown click.
     */
    public function markAsRead(Request $request)
    {
        $ids = $request->notification_ids ?? [];
        Notification::whereIn('id', $ids)
            ->where('user_id', Auth::id())
            ->update(['read_at' => now()]);

        return response()->json(['success' => true]);
    }
}