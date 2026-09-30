<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Modules\Core\Models\Union;
use Modules\Core\Models\Ward;
use Modules\Core\Models\Village;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Applicant-এর জন্য আলাদা dashboard
        if ($user->isApplicant()) {
            return redirect()->route('applicant.dashboard');
        }

        $stats = [
            'total_unions' => Union::count(),
            'total_wards' => Ward::count(),
            'total_villages' => Village::count(),
            'total_users' => User::count(),
            'total_admins' => User::whereIn('user_type', [
                'super_admin', 'chairman', 'secretary',
                'ward_member', 'accountant', 'certificate_officer',
            ])->count(),
            'total_applicants' => User::where('user_type', 'applicant')->count(),
        ];

        // Certificate related stats (যদি Certificate module থাকে)
        $certificateStats = [];
        if (class_exists(\Modules\Certificate\Models\CertificateApplication::class)) {
            $certificateStats = [
                'total_applications' => \Modules\Certificate\Models\CertificateApplication::count(),
                'pending' => \Modules\Certificate\Models\CertificateApplication::whereIn('status', [
                    'sent_to_ward', 'sent_to_chairman',
                ])->count(),
                'approved' => \Modules\Certificate\Models\CertificateApplication::where('status', 'chairman_approved')->count(),
                'today' => \Modules\Certificate\Models\CertificateApplication::whereDate('created_at', today())->count(),
            ];
        }

        return view('core::dashboard.index', compact('stats', 'certificateStats'));
    }
}