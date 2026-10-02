<?php

namespace Modules\Applicant\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Enums\ApplicationStatus;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $stats = [
            'total' => CertificateApplication::where('applicant_id', $user->id)->count(),
            'pending' => CertificateApplication::where('applicant_id', $user->id)
                ->whereIn('status', [
                    ApplicationStatus::PENDING_PAYMENT,
                    ApplicationStatus::SENT_TO_WARD,
                    ApplicationStatus::SENT_TO_CHAIRMAN,
                ])
                ->count(),
            'approved' => CertificateApplication::where('applicant_id', $user->id)
                ->where('status', ApplicationStatus::CHAIRMAN_APPROVED)
                ->count(),
            'rejected' => CertificateApplication::where('applicant_id', $user->id)
                ->whereIn('status', [
                    ApplicationStatus::WARD_REJECTED,
                    ApplicationStatus::CHAIRMAN_REJECTED,
                ])
                ->count(),
        ];

        $recentApplications = CertificateApplication::with(['certificateType'])
            ->where('applicant_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        return view('applicant::dashboard.index', compact('stats', 'recentApplications'));
    }
}