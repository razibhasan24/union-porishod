<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Payment\Models\Payment;
use Modules\Payment\Services\PaymentService;
use Modules\Payment\Services\GatewayService;

class ApplicantPaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService,
        protected GatewayService $gatewayService
    ) {}

    public function show(CertificateApplication $application)
    {
        if ($application->applicant_id !== auth()->id()) {
            abort(403, 'আপনার এই আবেদনে অনুমতি নেই।');
        }

        if ($application->payment_status === 'paid') {
            return redirect()
                ->route('applicant.applications.show', $application)
                ->with('info', 'এই আবেদনের পেমেন্ট সম্পন্ন হয়েছে।');
        }

        $gateways = $this->gatewayService->getAvailableGateways();

        return view('payment::applicant.show', compact('application', 'gateways'));
    }

    public function initiate(Request $request, CertificateApplication $application)
    {
        if ($application->applicant_id !== auth()->id()) {
            abort(403);
        }

        if ($application->payment_status === 'paid') {
            return redirect()->route('applicant.applications.show', $application);
        }

        $validated = $request->validate([
            'gateway' => 'required|in:bkash,nagad,rocket',
            'mobile' => 'required|string|max:20',
        ]);

        // Initiate payment
        $payment = $this->paymentService->initiateOnline($application, $validated);

        // MOCK: Process immediately
        $result = $this->gatewayService->processPayment($validated['gateway'], [
            'amount' => $application->amount,
            'mobile' => $validated['mobile'],
            'transaction_id' => $payment->transaction_id,
        ]);

        if ($result['success']) {
            $this->paymentService->markOnlinePaid($payment, $result);

            return redirect()
                ->route('applicant.payment.success', $payment)
                ->with('success', 'পেমেন্ট সফল হয়েছে!');
        }

        $this->paymentService->markOnlineFailed($payment, $result['message'] ?? 'Unknown error');

        return redirect()
            ->route('applicant.payment.failed', $payment)
            ->with('error', 'পেমেন্ট ব্যর্থ হয়েছে।');
    }

    public function callback(Payment $payment)
    {
        if ($payment->payer_id !== auth()->id()) {
            abort(403);
        }

        return redirect()->route('applicant.payment.success', $payment);
    }

    public function success(Payment $payment)
    {
        if ($payment->payer_id !== auth()->id()) {
            abort(403);
        }

        $application = $payment->application;

        return view('payment::applicant.success', compact('payment', 'application'));
    }

    public function failed(Payment $payment)
    {
        if ($payment->payer_id !== auth()->id()) {
            abort(403);
        }

        $application = $payment->application;

        return view('payment::applicant.failed', compact('payment', 'application'));
    }
}