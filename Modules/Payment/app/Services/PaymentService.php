<?php

namespace Modules\Payment\Services;

use Illuminate\Support\Facades\DB;
use Modules\Payment\Models\Payment;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Enums\ApplicationStatus;

class PaymentService
{
    /**
     * Initiate online payment (mock gateway for now)
     */
    public function initiateOnline(CertificateApplication $application, array $data): Payment
    {
        return DB::transaction(function () use ($application, $data) {
            $payment = Payment::create([
                'application_id' => $application->id,
                'payer_id' => auth()->id(),
                'amount' => $application->amount,
                'method' => 'online',
                'gateway' => $data['gateway'] ?? 'bkash',
                'payer_mobile' => $data['mobile'] ?? auth()->user()->phone,
                'transaction_id' => Payment::generateTransactionId($data['gateway'] ?? 'BKASH'),
                'status' => 'pending',
                'initiated_at' => now(),
            ]);

            // TODO: Actual gateway integration
            // For now, return payment record
            return $payment;
        });
    }

    /**
     * Mark online payment as successful
     */
    public function markOnlinePaid(Payment $payment, array $gatewayResponse = []): void
    {
        DB::transaction(function () use ($payment, $gatewayResponse) {
            $payment->update([
                'status' => 'success',
                'paid_at' => now(),
                'receipt_no' => Payment::generateReceiptNo(),
                'gateway_response' => $gatewayResponse,
            ]);

            $application = $payment->application;
            $application->update([
                'payment_status' => 'paid',
                'paid_amount' => $payment->amount,
                'payment_ref' => $payment->transaction_id,
                'paid_at' => now(),
                'status' => ApplicationStatus::SENT_TO_WARD,
            ]);

            $application->addLog('paid', 'পেমেন্ট সফল — ' . $payment->method_label);
        });
    }

    /**
     * Mark online payment as failed
     */
    public function markOnlineFailed(Payment $payment, string $reason = null): void
    {
        $payment->update([
            'status' => 'failed',
            'notes' => $reason,
        ]);
    }

    /**
     * Record cash payment (by office staff)
     */
    public function recordCash(CertificateApplication $application, array $data): Payment
    {
        return DB::transaction(function () use ($application, $data) {
            $payment = Payment::create([
                'application_id' => $application->id,
                'payer_id' => $application->applicant_id,
                'amount' => $data['amount'] ?? $application->amount,
                'method' => 'cash',
                'gateway' => 'cash',
                'transaction_id' => Payment::generateTransactionId('CASH'),
                'receipt_no' => $data['receipt_no'] ?? Payment::generateReceiptNo(),
                'payer_mobile' => $application->applicant_phone,
                'status' => 'success',
                'initiated_at' => now(),
                'paid_at' => now(),
                'collected_by' => auth()->id(),
                'notes' => $data['notes'] ?? 'নগদে পরিশোধিত',
            ]);

            $application->update([
                'payment_status' => 'paid',
                'paid_amount' => $payment->amount,
                'payment_ref' => $payment->receipt_no,
                'paid_at' => now(),
                'collected_by' => auth()->id(),
                'status' => ApplicationStatus::SENT_TO_WARD,
            ]);

            $application->addLog('cash_paid', 'নগদ পেমেন্ট গ্রহণ — রিসিট: ' . $payment->receipt_no);

            return $payment;
        });
    }
}