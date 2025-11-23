<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Admin payment management with permission checks.
 * Handles view, refund, and history for subscribed users/transporters/agents.
 */
class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin,operator');
        $this->middleware(function ($request, $next) {
            if (!Auth::user()->can_manage_payments) {
                abort(403, 'Insufficient permissions.');
            }
            return $next($request);
        });
    }

    /**
     * Display paginated payment history with filters (user, status, date).
     */
    public function index(Request $request)
    {
        $query = Payment::with(['user', 'vehicle'])
            ->orderBy('created_at', 'desc');

        // Filters
        $query->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
              ->when($request->status, fn($q) => $q->where('status', $request->status))
              ->when($request->date_from, fn($q) => $q->whereDate('created_at', '>=', $request->date_from))
              ->when($request->date_to, fn($q) => $q->whereDate('created_at', '<=', $request->date_to));

        $payments = $query->paginate(15);
        $users = User::select('id', 'name', 'email')->get(); // For filter dropdown

        return view('admin.payments.index', compact('payments', 'users'));
    }

    /**
     * Show payment details with refund option if applicable.
     */
    public function show(Payment $payment)
    {
        $this->authorize('view', $payment); // Policy: operators see own scope
        $payment->load(['user.vehicles', 'vehicle.photos']);

        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Process refund: Update status, notify user via email.
     */
    public function refund(Request $request, Payment $payment)
    {
        $this->authorize('refund', $payment);

        $request->validate(['reason' => 'required|string|max:500']);

        DB::transaction(function () use ($payment, $request) {
            $payment->update([
                'status' => 'refunded',
                'refund_reason' => $request->reason,
                'refunded_at' => now()
            ]);

            // Gateway integration (e.g., Stripe refund via config)
            $gateway = config('payments.gateway', 'stripe');
            if ($gateway === 'stripe' && $payment->gateway_transaction_id) {
                // Placeholder: Use Stripe SDK (composer require stripe/stripe-php)
                // \Stripe\Refund::create(['payment_intent' => $payment->gateway_transaction_id]);
            }

            // Notify user
            $payment->user->notify(new \App\Notifications\PaymentRefunded($payment));
        });

        return redirect()->route('admin.payments.show', $payment)->with('success', 'Refund processed.');
    }

    /**
     * Export payments to CSV (for reports).
     */
    public function export(Request $request)
    {
        $payments = Payment::with('user')->get(); // Apply filters as in index()

        $filename = 'chaloo_payments_' . now()->format('Y-m-d') . '.csv';
        $headers = ['Content-Type' => 'text/csv', 'Content-Disposition' => "attachment; filename={$filename}"];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['ID', 'User', 'Amount', 'Status', 'Date']);
            foreach ($payments as $payment) {
                fputcsv($file, [$payment->id, $payment->user->name, $payment->amount, $payment->status, $payment->created_at]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}