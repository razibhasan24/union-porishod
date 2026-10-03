<?php

namespace Modules\Setting\Listeners;

use Modules\Setting\Events\ApplicationStatusChanged;
use Modules\Setting\Services\SmsService;

class SendApplicationStatusSms
{
    public function __construct(
        protected SmsService $smsService
    ) {}

    public function handle(ApplicationStatusChanged $event): void
    {
        $application = $event->application;
        $toStatus = $event->toStatus;

        // Template map
        $templateMap = [
            'sent_to_ward' => 'application_sent_to_ward',
            'ward_verified' => 'application_ward_verified',
            'ward_rejected' => 'application_ward_rejected',
            'sent_to_chairman' => 'application_sent_to_chairman',
            'chairman_approved' => 'application_approved',
            'chairman_rejected' => 'application_rejected',
            'chairman_hold' => 'application_hold',
            'ready_for_print' => 'application_print_ready',
            'paid' => 'application_paid',
        ];

        $templateKey = $templateMap[$toStatus] ?? null;

        if (!$templateKey) {
            return;
        }

        $applicant = $application->applicant;

        if (!$applicant || !$applicant->phone) {
            return;
        }

        $data = [
            'name' => $applicant->name_bn ?? $applicant->name,
            'tracking_no' => $application->tracking_no,
            'certificate_type' => $application->certificateType->name_bn ?? '',
            'amount' => number_format($application->amount, 0),
            'remarks' => $event->remarks ?? '',
            'union_name' => $application->union->name_bn ?? '',
        ];

        // SMS to applicant
        $this->smsService->sendFromTemplate(
            $templateKey,
            $applicant->phone,
            $data,
            $application,
            $applicant->id
        );

        // Notify Ward Member (only on sent_to_ward)
        if ($toStatus === 'sent_to_ward' && $application->ward) {
            $wardMember = $application->ward->wardMember;
            if ($wardMember && $wardMember->phone) {
                $this->smsService->sendFromTemplate(
                    'ward_member_new_application',
                    $wardMember->phone,
                    [
                        'name' => $wardMember->name_bn ?? $wardMember->name,
                        'tracking_no' => $application->tracking_no,
                        'applicant_name' => $application->applicant_name_bn,
                        'certificate_type' => $application->certificateType->name_bn ?? '',
                    ],
                    $application,
                    $wardMember->id
                );
            }
        }

        // Notify Chairman (only on sent_to_chairman)
        if ($toStatus === 'sent_to_chairman') {
            $chairman = $application->union->users()
                ->where('user_type', 'chairman')
                ->first();

            if ($chairman && $chairman->phone) {
                $this->smsService->sendFromTemplate(
                    'chairman_new_application',
                    $chairman->phone,
                    [
                        'name' => $chairman->name_bn ?? $chairman->name,
                        'tracking_no' => $application->tracking_no,
                        'applicant_name' => $application->applicant_name_bn,
                        'certificate_type' => $application->certificateType->name_bn ?? '',
                    ],
                    $application,
                    $chairman->id
                );
            }
        }
    }
}