<?php

namespace Modules\Applicant\Services;

use Illuminate\Support\Facades\DB;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Models\CertificateType;
use Modules\Certificate\Enums\ApplicationStatus;

class ApplicationService
{
    public function createApplication(array $data): CertificateApplication
    {
        return DB::transaction(function () use ($data) {
            $user = auth()->user();
            $type = CertificateType::findOrFail($data['certificate_type_id']);

            // Tracking No
            $trackingNo = 'CERT-' . date('Ymd') . '-' . strtoupper(substr(md5(uniqid('', true)), 0, 6));

            // Payment method
            $paymentMethod = $data['payment_method'] ?? 'online';
            $amount = $type->fee;

            $application = CertificateApplication::create([
                'tracking_no' => $trackingNo,
                'union_id' => $user->union_id ?? $type->union_id,
                'ward_id' => $data['ward_id'] ?? $user->ward_id,
                'village_id' => $data['village_id'] ?? $user->village_id,
                'applicant_id' => $user->id,
                'certificate_type_id' => $type->id,

                // Snapshot
                'applicant_name_bn' => $user->name_bn ?? $user->name,
                'applicant_name_en' => $user->name,
                'applicant_nid' => $user->nid,
                'applicant_phone' => $data['applicant_phone'],
                'applicant_address' => $data['address'] ?? null,
                'applicant_father_name' => $data['father_name'] ?? null,
                'applicant_mother_name' => $data['mother_name'] ?? null,

                // Form data
                'form_data' => [
                    'purpose' => $data['purpose'] ?? null,
                    'extra' => $data['extra'] ?? [],
                ],

                // Documents
                'documents' => $data['documents'] ?? [],

                // Warish info
                'deceased_info' => $data['deceased_info'] ?? null,
                'heirs' => $data['heirs'] ?? null,
                'property_info' => $data['property_info'] ?? null,

                // Payment
                'payment_method' => $paymentMethod,
                'payment_status' => 'unpaid',
                'amount' => $amount,
                'paid_amount' => 0,

                // Status
                'status' => ApplicationStatus::PENDING_PAYMENT,
            ]);

            // Log
            $application->addLog('created', 'আবেদন তৈরি করা হয়েছে');

            return $application;
        });
    }

    public function uploadDocuments(array $files): array
    {
        $paths = [];
        foreach ($files as $file) {
            if ($file && $file->isValid()) {
                $paths[] = $file->store('applications', 'public');
            }
        }
        return $paths;
    }
}
