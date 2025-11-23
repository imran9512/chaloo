<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

/**
 * Admin settings for email and globals.
 */
class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show email config form.
     */
    public function email()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray(); // Key-value store
        return view('admin.settings.email', compact('settings'));
    }

    /**
     * Update email settings and test.
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'smtp_host' => 'required|string',
            'smtp_port' => 'required|integer',
            'smtp_username' => 'required|string',
            'smtp_password' => 'required|string',
            'from_email' => 'required|email',
            'from_name' => 'required|string',
            'reset_subject' => 'required|string',
            'reset_body' => 'required|string'
        ]);

        // Update settings table
        $fields = $request->only(['smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'from_email', 'from_name', 'reset_subject', 'reset_body']);
        foreach ($fields as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        // Clear config cache for shared hosting
        Artisan::call('config:cache');

        // Test email if requested
        if ($request->test_email) {
            try {
                Mail::raw('Test email from Chaloo.', function ($message) use ($request) {
                    $message->to($request->test_to ?? auth()->user()->email)
                            ->subject('Test - ' . config('app.name'));
                });
                return back()->with('success', 'Settings updated and test sent.');
            } catch (\Exception $e) {
                return back()->withErrors(['test' => 'Test failed: ' . $e->getMessage()]);
            }
        }

        return back()->with('success', 'Settings updated.');
    }
}