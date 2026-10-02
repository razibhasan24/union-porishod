<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Payment\Models\Payment;
use Modules\Payment\Services\PaymentService;

class AdminPaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {}

    public function index()
    {
        $payments = Payment::with(['application', 'payer', 'collectedBy'])
            ->when(request('status'), fn($q, $s) => $q->where('status', $s))
            ->when(request('method'), fn($q, $m) => $q->where('method', $m))
            ->when(request('search'), function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('transaction_id', 'like', "%{$search}%")
                      ->orWhere('receipt_no', 'like', "%{$search}%")
                      ->orWhere('payer_mobile', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(20);

        $stats = [
            'total_paid' => Payment::where('status', 'success')->sum('amount'),
            'today_paid' => Payment::where('status', 'success')->whereDate('paid_at', today())->sum('amount'),
            'pending_online' => Payment::where('status', 'pending')->where('method', 'online')->count(),
            'today_count' => Payment::where('status', 'success')->whereDate('paid_at', today())->count(),
        ];

        return view('payment::admin.index', compact('payments', 'stats'));
    }

    public function cashEntryForm()
    {
        return view('payment::admin.cash-entry');
    }

    public function recordCash(Request $request)
    {
        $validated = $request->validate([
            'tracking_no' => 'required|string|exists:certificate_applications,tracking_no',
            'amount' => 'required|numeric|min:0',
            'receipt_no' => 'nullable|string|max:100',
            'notes' => 'nullable|string|max:500',
        ]);

        $application = CertificateApplication::where('tracking_no', $validated['tracking_no'])->firstOrFail();

        if ($application->payment_status === 'paid') {
            return back()->with('error', 'এই আবেদনের পেমেন্ট আগেই সম্পন্ন হয়েছে।');
        }

        $payment = $this->paymentService->recordCash($application, $validated);

        return redirect()
            ->route('payment.admin.show', $payment)
            ->with('success', 'নগদ পেমেন্ট সফলভাবে রেকর্ড হয়েছে। রিসিট: ' . $payment->receipt_no);
    }

    public function show(Payment $payment)
    {
        $payment->load(['application', 'payer', 'collectedBy']);

        return view('payment::admin.show', compact('payment'));
    }

    public function receipt(Payment $payment)
    {
        $payment->load(['application', 'payer', 'collectedBy']);

        return view('payment::admin.receipt', compact('payment'));
    }
}