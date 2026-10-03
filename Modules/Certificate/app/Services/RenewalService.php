<?php

namespace Modules\Certificate\Services;

use Illuminate\Support\Facades\DB;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Models\IssuedCertificate;
use Modules\Certificate\Enums\ApplicationStatus;

class RenewalService
{
    public function __construct(
        protected CertificateNumberService $numberService
    ) {}

    /**
     * Create renewal application
     */
    public function createRenewal(CertificateApplication $original, array $data = []): CertificateApplication
    {
        if (!$this->canBeRenewed($original)) {
            throw new \Exception('এই আবেদন নবায়ন করা যাবে না।');
        }

        return DB::transaction(function () use ($original, $data) {
            $type = $original->certificateType;

            // Renewal fee (fallback to original fee)
            $fee = $data['amount'] ?? ($type->renewal_fee ?? $type->fee);

            // Tracking number
            $trackingNo = 'REN-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));

            // Payment method
            $paymentMethod = $data['payment_method'] ?? 'online';

            $renewal = CertificateApplication::create([
                'tracking_no' => $trackingNo,
                'union_id' => $original->union_id,
                'ward_id' => $original->ward_id,
                'village_id' => $original->village_id,
                'applicant_id' => $original->applicant_id,
                'certificate_type_id' => $original->certificate_type_id,

                // Copy snapshot
                'applicant_name_bn' => $original->applicant_name_bn,
                'applicant_name_en' => $original->applicant_name_en,
                'applicant_father_name' => $original->applicant_father_name,
                'applicant_mother_name' => $original->applicant_mother_name,
                'applicant_nid' => $original->applicant_nid,
                'applicant_phone' => $original->applicant_phone,
                'applicant_address' => $original->applicant_address,

                'form_data' => [
                    'purpose' => $data['purpose'] ?? 'নবায়ন',
                    'renewal_of' => $original->tracking_no,
                ],

                'documents' => $original->documents,

                // Payment
                'payment_method' => $paymentMethod,
                'payment_status' => 'unpaid',
                'amount' => $fee,
                'paid_amount' => 0,

                // Status
                'status' => ApplicationStatus::PENDING_PAYMENT,

                // Renewal references
                'parent_application_id' => $original->id,
                'is_renewal' => true,
                'renewal_count' => ($original->renewal_count ?? 0) + 1,
            ]);

            // Mark original as renewed
            $original->update(['status' => ApplicationStatus::RENEWED]);

            $renewal->addLog('renewal_created', 'মূল আবেদন: ' . $original->tracking_no . ' থেকে নবায়ন');

            return $renewal;
        });
    }

    /**
     * Check if an application can be renewed
     */
    public function canBeRenewed(CertificateApplication $application): bool
    {
        // Original must be approved/issued
        if (!in_array($application->status, [
            ApplicationStatus::CHAIRMAN_APPROVED,
            ApplicationStatus::READY_FOR_PRINT,
            ApplicationStatus::PRINTED,
            ApplicationStatus::DELIVERED,
            ApplicationStatus::EXPIRED,
            ApplicationStatus::RENEWED,
        ])) {
            return false;
        }

        // Already renewed - cannot renew again (must renew the latest)
        if ($application->renewals()->whereIn('status', [
            ApplicationStatus::PENDING_PAYMENT,
            ApplicationStatus::PAID,
            ApplicationStatus::SENT_TO_WARD,
            ApplicationStatus::SENT_TO_CHAIRMAN,
            ApplicationStatus::CHAIRMAN_APPROVED,
        ])->exists()) {
            return false;
        }

        // Expired or near expiry (within 30 days)
        $certificate = $application->issuedCertificate;
        if ($certificate && $certificate->expiry_date) {
            return $certificate->expiry_date->isPast()
                || $certificate->expiry_date->diffInDays(now()) <= 30;
        }

        return false;
    }

    /**
     * Get renewable applications for an applicant
     */
    public function getRenewableApplications(int $applicantId)
    {
        return CertificateApplication::with(['certificateType', 'issuedCertificate'])
            ->where('applicant_id', $applicantId)
            ->whereIn('status', [
                ApplicationStatus::CHAIRMAN_APPROVED,
                ApplicationStatus::READY_FOR_PRINT,
                ApplicationStatus::PRINTED,
                ApplicationStatus::DELIVERED,
                ApplicationStatus::EXPIRED,
                ApplicationStatus::RENEWED,
            ])
            ->whereDoesntHave('renewals', function ($q) {
                $q->whereIn('status', [
                    ApplicationStatus::PENDING_PAYMENT,
                    ApplicationStatus::PAID,
                    ApplicationStatus::SENT_TO_WARD,
                    ApplicationStatus::SENT_TO_CHAIRMAN,
                    ApplicationStatus::CHAIRMAN_APPROVED,
                ]);
            })
            ->latest()
            ->get()
            ->filter(fn($app) => $this->canBeRenewed($app));
    }
}