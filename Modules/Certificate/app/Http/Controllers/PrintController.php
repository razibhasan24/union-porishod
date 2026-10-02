<?php

namespace Modules\Certificate\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Services\CertificatePdfService;
use Modules\Certificate\Enums\ApplicationStatus;

class PrintController extends Controller
{
    public function __construct(
        protected CertificatePdfService $pdfService
    ) {}

    public function printPdf(CertificateApplication $application)
    {
        // Check permission
        if (!$this->canPrint($application)) {
            return back()->with('error', 'এই মুহূর্তে প্রিন্ট করার অনুমতি নেই।');
        }

        // Increment print count
        if ($application->issuedCertificate) {
            $application->issuedCertificate->incrementPrintCount('first', 'Admin print');
        }

        // Stream PDF in browser
        return $this->pdfService->stream($application);
    }

    public function downloadPdf(CertificateApplication $application)
    {
        if (!$this->canPrint($application)) {
            return back()->with('error', 'ডাউনলোড করার অনুমতি নেই।');
        }

        return $this->pdfService->download($application);
    }

    public function previewPdf(CertificateApplication $application)
    {
        // Preview doesn't increment counter
        return $this->pdfService->stream($application);
    }

    protected function canPrint(CertificateApplication $application): bool
    {
        $user = auth()->user();

        // Super Admin সব সময় পারবে
        if ($user->isSuperAdmin()) {
            return true;
        }

        // Applicant নিজের certificate print করতে পারবে (if canBePrinted)
        if ($user->isApplicant() && $application->applicant_id === $user->id) {
            return $application->canBePrinted();
        }

        // Chairman সব print করতে পারবে (approved হলে)
        if ($user->isChairman()) {
            return in_array($application->status, [
                ApplicationStatus::CHAIRMAN_APPROVED,
                ApplicationStatus::READY_FOR_PRINT,
                ApplicationStatus::PRINTED,
                ApplicationStatus::DELIVERED,
            ]);
        }

        return false;
    }
}