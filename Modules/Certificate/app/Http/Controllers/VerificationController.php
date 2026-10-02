<?php

namespace Modules\Certificate\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Certificate\Models\IssuedCertificate;

class VerificationController extends Controller
{
    /**
     * Show verification form
     */
    public function form()
    {
        return view('certificate::verify.form');
    }

    /**
     * Verify certificate by code
     */
    public function verify(string $code)
    {
        $certificate = IssuedCertificate::with([
            'application.certificateType',
            'application.union',
            'application.ward',
            'application.applicant',
        ])
        ->where('verification_code', $code)
        ->orWhere('certificate_no', $code)
        ->first();

        if (!$certificate) {
            return view('certificate::verify.result', [
                'valid' => false,
                'code' => $code,
                'message' => 'এই কোড দিয়ে কোন সার্টিফিকেট পাওয়া যায়নি।',
            ]);
        }

        // Check if expired or cancelled
        $isExpired = $certificate->isExpired();
        $isCancelled = $certificate->is_cancelled;
        $isValid = $certificate->is_valid && !$isExpired && !$isCancelled;

        return view('certificate::verify.result', [
            'valid' => $isValid,
            'certificate' => $certificate,
            'application' => $certificate->application,
            'code' => $code,
            'isExpired' => $isExpired,
            'isCancelled' => $isCancelled,
            'message' => $isValid ? 'সার্টিফিকেটটি বৈধ।' : ($isCancelled ? 'সার্টিফিকেটটি বাতিল করা হয়েছে।' : ($isExpired ? 'সার্টিফিকেটের মেয়াদ শেষ হয়েছে।' : 'সার্টিফিকেটটি সঠিক নয়।')),
        ]);
    }
}