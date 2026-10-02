<?php

namespace Modules\Certificate\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Http\Request;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Services\ApplicationWorkflowService;
use Modules\Certificate\Enums\ApplicationStatus;

class CertificateApplicationController extends Controller implements HasMiddleware
{
    public function __construct(
        protected ApplicationWorkflowService $workflow
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:certificate_application.view', only: [
                'index', 'show', 'pendingForWard', 'pendingForChairman',
            ]),
            new Middleware('permission:certificate_application.approve', only: [
                'wardRecommend', 'chairmanApprove', 'allowPrint',
            ]),
            new Middleware('permission:certificate_application.reject', only: [
                'wardReject', 'chairmanReject', 'chairmanHold',
            ]),
        ];
    }

    public function index()
    {
        $query = CertificateApplication::with(['applicant', 'certificateType', 'ward', 'union'])
            ->when(request('status'), fn($q, $status) => $q->where('status', $status))
            ->when(request('ward_id'), fn($q, $id) => $q->where('ward_id', $id))
            ->when(request('certificate_type_id'), fn($q, $id) => $q->where('certificate_type_id', $id))
            ->when(request('search'), function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('tracking_no', 'like', "%{$search}%")
                      ->orWhere('applicant_name_bn', 'like', "%{$search}%")
                      ->orWhere('applicant_phone', 'like', "%{$search}%")
                      ->orWhere('applicant_nid', 'like', "%{$search}%");
                });
            });

        // Ward Member শুধু নিজের ওয়ার্ডের আবেদন দেখবে
        if (auth()->user()->isWardMember()) {
            $query->where('ward_id', auth()->user()->ward_id);
        }

        $applications = $query->latest()->paginate(20);

        return view('certificate::applications.index', compact('applications'));
    }

    public function pendingForWard()
    {
        $applications = CertificateApplication::with(['applicant', 'certificateType'])
            ->where('ward_id', auth()->user()->ward_id)
            ->where('status', ApplicationStatus::SENT_TO_WARD)
            ->latest()
            ->paginate(20);

        return view('certificate::applications.pending', compact('applications'));
    }

    public function pendingForChairman()
    {
        $applications = CertificateApplication::with(['applicant', 'certificateType', 'ward', 'wardMember'])
            ->where('status', ApplicationStatus::SENT_TO_CHAIRMAN)
            ->latest()
            ->paginate(20);

        return view('certificate::applications.pending-chairman', compact('applications'));
    }

    public function show(CertificateApplication $application)
    {
        $application->load([
            'applicant', 'certificateType', 'ward', 'village', 'union',
            'wardMember', 'chairman', 'issuedCertificate', 'logs.user',
        ]);

        return view('certificate::applications.show', compact('application'));
    }

    public function wardRecommend(Request $request, CertificateApplication $application)
    {
        $request->validate(['remarks' => 'nullable|string|max:500']);

        if (!auth()->user()->isWardMember() || $application->ward_id !== auth()->user()->ward_id) {
            abort(403, 'আপনার এই আবেদনে অনুমতি নেই।');
        }

        $this->workflow->wardRecommend($application, $request->remarks);

        return redirect()
            ->route('certificate.applications.pending')
            ->with('success', 'আবেদন চেয়ারম্যানের কাছে পাঠানো হয়েছে।');
    }

    public function wardReject(Request $request, CertificateApplication $application)
    {
        $request->validate(['remarks' => 'required|string|max:500']);

        if (!auth()->user()->isWardMember() || $application->ward_id !== auth()->user()->ward_id) {
            abort(403, 'আপনার এই আবেদনে অনুমতি নেই।');
        }

        $this->workflow->wardReject($application, $request->remarks);

        return redirect()
            ->route('certificate.applications.pending')
            ->with('success', 'আবেদন বাতিল করা হয়েছে।');
    }

    public function chairmanApprove(Request $request, CertificateApplication $application)
    {
        $request->validate(['remarks' => 'nullable|string|max:500']);

        if (!auth()->user()->isChairman()) {
            abort(403, 'শুধু চেয়ারম্যান অনুমোদন করতে পারেন।');
        }

        $this->workflow->chairmanApprove($application, $request->remarks);

        return redirect()
            ->route('certificate.applications.pending-chairman')
            ->with('success', 'আবেদন অনুমোদিত হয়েছে এবং সার্টিফিকেট তৈরি হয়েছে।');
    }

    public function chairmanReject(Request $request, CertificateApplication $application)
    {
        $request->validate(['remarks' => 'required|string|max:500']);

        if (!auth()->user()->isChairman()) {
            abort(403, 'শুধু চেয়ারম্যান বাতিল করতে পারেন।');
        }

        $this->workflow->chairmanReject($application, $request->remarks);

        return redirect()
            ->route('certificate.applications.pending-chairman')
            ->with('success', 'আবেদন বাতিল করা হয়েছে।');
    }

    public function chairmanHold(Request $request, CertificateApplication $application)
    {
        $request->validate(['remarks' => 'required|string|max:500']);

        if (!auth()->user()->isChairman()) {
            abort(403, 'শুধু চেয়ারম্যান স্থগিত করতে পারেন।');
        }

        $this->workflow->chairmanHold($application, $request->remarks);

        return redirect()
            ->route('certificate.applications.pending-chairman')
            ->with('success', 'আবেদন স্থগিত করা হয়েছে।');
    }

    public function allowPrint(Request $request, CertificateApplication $application)
    {
        $request->validate(['reason' => 'required|string|max:500']);

        if (!auth()->user()->isChairman()) {
            abort(403, 'শুধু চেয়ারম্যান অনুমতি দিতে পারেন।');
        }

        $this->workflow->allowEarlyPrint($application, $request->reason);

        return back()->with('success', 'প্রিন্টের অনুমতি দেওয়া হয়েছে।');
    }
}