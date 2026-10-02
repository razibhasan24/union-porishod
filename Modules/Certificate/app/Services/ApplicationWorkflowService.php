<?php

namespace Modules\Certificate\Services;

use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Models\IssuedCertificate;
use Modules\Certificate\Enums\ApplicationStatus;

class ApplicationWorkflowService
{
    public function __construct(
        protected CertificateNumberService $numberService
    ) {}

    public function markAsPaid(CertificateApplication $application, array $paymentData): void
    {
        $application->update([
            'payment_status' => 'paid',
            'paid_amount' => $paymentData['amount'] ?? $application->amount,
            'payment_ref' => $paymentData['reference'] ?? null,
            'payment_method' => $paymentData['method'] ?? $application->payment_method,
            'paid_at' => now(),
            'collected_by' => $paymentData['collected_by'] ?? null,
            'status' => ApplicationStatus::SENT_TO_WARD,
        ]);

        $application->addLog('paid', 'পেমেন্ট সম্পন্ন');
    }

    public function wardRecommend(CertificateApplication $application, string $remarks = null): void
    {
        $application->update([
            'ward_member_id' => auth()->id(),
            'ward_action_at' => now(),
            'ward_remarks' => $remarks,
            'status' => ApplicationStatus::SENT_TO_CHAIRMAN,
        ]);

        $application->addLog('ward_recommended', $remarks ?? 'ওয়ার্ড সদস্য সুপারিশ করেছেন');
    }

    public function wardReject(CertificateApplication $application, string $remarks): void
    {
        $application->update([
            'ward_member_id' => auth()->id(),
            'ward_action_at' => now(),
            'ward_remarks' => $remarks,
            'status' => ApplicationStatus::WARD_REJECTED,
        ]);

        $application->addLog('ward_rejected', $remarks);
    }

    public function chairmanApprove(CertificateApplication $application, string $remarks = null): IssuedCertificate
    {
        // Calculate print availability date
        $type = $application->certificateType;
        $printAfterDays = $type->print_after_days ?? 0;
        $printAvailableAt = $printAfterDays > 0 ? now()->addDays($printAfterDays) : now();

        // Calculate expiry
        $expiryDays = $type->validity_days ?? 90;
        $expiryDate = now()->addDays($expiryDays);

        $application->update([
            'chairman_id' => auth()->id(),
            'chairman_action_at' => now(),
            'chairman_remarks' => $remarks,
            'status' => ApplicationStatus::CHAIRMAN_APPROVED,
            'print_available_at' => $printAvailableAt,
        ]);

        $application->addLog('chairman_approved', $remarks ?? 'চেয়ারম্যান অনুমোদন করেছেন');

        // Create IssuedCertificate
        $certificate = IssuedCertificate::create([
            'application_id' => $application->id,
            'certificate_no' => $this->numberService->generate($type),
            'issue_date' => now()->toDateString(),
            'expiry_date' => $expiryDate->toDateString(),
            'verification_code' => $this->numberService->generateVerificationCode(),
            'issued_by' => auth()->id(),
            'issued_by_name' => auth()->user()->name_bn ?? auth()->user()->name,
            'issued_by_designation' => 'চেয়ারম্যান',
            'is_valid' => true,
        ]);

        return $certificate;
    }

    public function chairmanReject(CertificateApplication $application, string $remarks): void
    {
        $application->update([
            'chairman_id' => auth()->id(),
            'chairman_action_at' => now(),
            'chairman_remarks' => $remarks,
            'status' => ApplicationStatus::CHAIRMAN_REJECTED,
        ]);

        $application->addLog('chairman_rejected', $remarks);
    }

    public function chairmanHold(CertificateApplication $application, string $remarks): void
    {
        $application->update([
            'chairman_id' => auth()->id(),
            'chairman_action_at' => now(),
            'chairman_remarks' => $remarks,
            'status' => ApplicationStatus::CHAIRMAN_HOLD,
        ]);

        $application->addLog('chairman_hold', $remarks);
    }

    public function allowEarlyPrint(CertificateApplication $application, string $reason): void
    {
        $application->update([
            'print_allowed' => true,
            'print_allowed_by' => auth()->id(),
            'print_allowed_at' => now(),
            'status' => ApplicationStatus::READY_FOR_PRINT,
        ]);

        $application->addLog('print_allowed', $reason);
    }
}