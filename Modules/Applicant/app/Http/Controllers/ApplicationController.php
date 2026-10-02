<?php

namespace Modules\Applicant\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Applicant\Services\ApplicationService;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Models\CertificateType;
use Modules\Core\Models\Ward;
use Modules\Core\Models\Village;
use Modules\Certificate\Enums\ApplicationStatus;

class ApplicationController extends Controller
{
    public function __construct(
        protected ApplicationService $service
    ) {}

    public function index()
    {
        $applications = CertificateApplication::with(['certificateType'])
            ->where('applicant_id', auth()->id())
            ->latest()
            ->paginate(15);

        return view('applicant::applications.index', compact('applications'));
    }

    public function create()
    {
        $user = auth()->user();
        $types = CertificateType::where('is_active', true)
            ->where(function ($q) use ($user) {
                if ($user->union_id) {
                    $q->where('union_id', $user->union_id);
                }
            })
            ->orderBy('sort_order')
            ->get();

        $wards = Ward::where('union_id', $user->union_id)
            ->orderBy('ward_no')
            ->get();

        $villages = Village::when($user->ward_id, fn($q, $id) => $q->where('ward_id', $id))
            ->orderBy('name_bn')
            ->get();

        return view('applicant::applications.create', compact('types', 'wards', 'villages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'certificate_type_id' => 'required|exists:certificate_types,id',
            'ward_id' => 'required|exists:wards,id',
            'village_id' => 'nullable|exists:villages,id',
            'purpose' => 'required|string|max:500',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'payment_method' => 'required|in:online,cash',
            'documents.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        // Upload documents
        $documents = [];
        if ($request->hasFile('documents')) {
            $documents = $this->service->uploadDocuments($request->file('documents'));
        }
        $validated['documents'] = $documents;

        // Warish-specific data
        if ($request->has('heirs') && is_array($request->heirs)) {
            $validated['heirs'] = array_values(array_filter($request->heirs, function ($h) {
                return !empty($h['name']);
            }));
        }
        if ($request->has('deceased_info')) {
            $validated['deceased_info'] = $request->deceased_info;
        }
        if ($request->has('property_info')) {
            $validated['property_info'] = $request->property_info;
        }

        $application = $this->service->createApplication($validated);

        return redirect()
            ->route('applicant.applications.show', $application)
            ->with('success', 'আবেদন সফলভাবে জমা হয়েছে। ট্র্যাকিং নম্বর: ' . $application->tracking_no);
    }

    public function show(CertificateApplication $application)
    {
        if ($application->applicant_id !== auth()->id()) {
            abort(403, 'আপনার এই আবেদনে অনুমতি নেই।');
        }

        $application->load(['certificateType', 'ward', 'village', 'union', 'issuedCertificate', 'logs']);

        return view('applicant::applications.show', compact('application'));
    }

    public function receipt(CertificateApplication $application)
    {
        if ($application->applicant_id !== auth()->id()) {
            abort(403);
        }

        $application->load(['certificateType', 'union']);

        return view('applicant::applications.receipt', compact('application'));
    }

    public function print(CertificateApplication $application)
    {
        if ($application->applicant_id !== auth()->id()) {
            abort(403);
        }

        if (!$application->canBePrinted()) {
            return back()->with('error', 'এই মুহূর্তে সার্টিফিকেট প্রিন্ট করার অনুমতি নেই।');
        }

        $application->load(['certificateType', 'union', 'issuedCertificate']);

        if ($application->issuedCertificate) {
            $application->issuedCertificate->incrementPrintCount('first', 'Applicant print');
        }

        return view('applicant::applications.print', compact('application'));
    }

    public function requestEarlyPrint(Request $request, CertificateApplication $application)
    {
        if ($application->applicant_id !== auth()->id()) {
            abort(403);
        }

        $request->validate(['reason' => 'required|string|max:500']);

        $application->addLog('early_print_requested', $request->reason);

        return back()->with('success', 'প্রিন্ট অনুরোধ চেয়ারম্যানের কাছে পাঠানো হয়েছে।');
    }
}