<?php

namespace Modules\Applicant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Services\RenewalService;

class RenewalController extends Controller
{
    public function __construct(
        protected RenewalService $renewalService
    ) {}

    /**
     * List renewable certificates
     */
    public function index()
    {
        $renewableApplications = $this->renewalService
            ->getRenewableApplications(auth()->id());

        // Already renewed (in progress)
        $inProgressRenewals = CertificateApplication::with(['certificateType', 'parentApplication'])
            ->where('applicant_id', auth()->id())
            ->where('is_renewal', true)
            ->whereIn('status', [
                'pending_payment', 'paid', 'sent_to_ward',
                'sent_to_chairman', 'chairman_approved',
            ])
            ->latest()
            ->get();

        return view('applicant::renewals.index', compact('renewableApplications', 'inProgressRenewals'));
    }

    /**
     * Show renewal form
     */
    public function create(CertificateApplication $application)
    {
        // Security check
        if ($application->applicant_id !== auth()->id()) {
            abort(403);
        }

        if (!$this->renewalService->canBeRenewed($application)) {
            return redirect()
                ->route('applicant.renewals.index')
                ->with('error', 'এই সার্টিফিকেটটি এই মুহূর্তে নবায়ন করা যাবে না।');
        }

        $application->load(['certificateType', 'issuedCertificate', 'ward', 'union']);

        return view('applicant::renewals.create', compact('application'));
    }

    /**
     * Store renewal
     */
    public function store(Request $request, CertificateApplication $application)
    {
        if ($application->applicant_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'payment_method' => 'required|in:online,cash',
            'purpose' => 'nullable|string|max:500',
        ]);

        try {
            $renewal = $this->renewalService->createRenewal($application, $validated);

            return redirect()
                ->route('applicant.applications.show', $renewal)
                ->with('success', 'নবায়ন আবেদন সফলভাবে জমা হয়েছে। ট্র্যাকিং: ' . $renewal->tracking_no);
        } catch (\Throwable $e) {
            return back()->with('error', 'নবায়ন ব্যর্থ: ' . $e->getMessage());
        }
    }
}