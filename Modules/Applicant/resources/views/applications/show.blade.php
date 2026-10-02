@extends('applicant::layouts.app')

@section('title', 'আবেদন: ' . $application->tracking_no)

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>
        <i class="bi bi-file-earmark-text"></i>
        {{ $application->certificateType->name_bn ?? '' }}
    </h4>
    <a href="{{ route('applicant.applications.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

@php
    $status = $application->status instanceof \Modules\Certificate\Enums\ApplicationStatus
        ? $application->status
        : \Modules\Certificate\Enums\ApplicationStatus::from($application->status ?? 'draft');
@endphp

{{-- Status Banner --}}
<div class="alert alert-{{ $status->color() }} d-flex justify-content-between align-items-center">
    <div>
        <strong>স্ট্যাটাস:</strong> {{ $status->labelBn() }}
    </div>
    <code>{{ $application->tracking_no }}</code>
</div>

<div class="row g-3">
    <div class="col-md-8">
        {{-- Progress Timeline --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>অগ্রগতি</strong></div>
            <div class="card-body">
                @php
                    $steps = [
                        ['label' => 'আবেদন জমা', 'done' => true],
                        ['label' => 'পেমেন্ট', 'done' => $application->isPaid()],
                        ['label' => 'ওয়ার্ড সদস্য যাচাই', 'done' => in_array($status, [
                            \Modules\Certificate\Enums\ApplicationStatus::SENT_TO_CHAIRMAN,
                            \Modules\Certificate\Enums\ApplicationStatus::CHAIRMAN_APPROVED,
                            \Modules\Certificate\Enums\ApplicationStatus::READY_FOR_PRINT,
                            \Modules\Certificate\Enums\ApplicationStatus::PRINTED,
                            \Modules\Certificate\Enums\ApplicationStatus::DELIVERED,
                        ])],
                        ['label' => 'চেয়ারম্যান অনুমোদন', 'done' => in_array($status, [
                            \Modules\Certificate\Enums\ApplicationStatus::CHAIRMAN_APPROVED,
                            \Modules\Certificate\Enums\ApplicationStatus::READY_FOR_PRINT,
                            \Modules\Certificate\Enums\ApplicationStatus::PRINTED,
                            \Modules\Certificate\Enums\ApplicationStatus::DELIVERED,
                        ])],
                        ['label' => 'প্রিন্টের জন্য প্রস্তুত', 'done' => $application->canBePrinted()],
                    ];
                @endphp

                @foreach($steps as $i => $step)
                <div class="d-flex align-items-center mb-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center me-3
                        {{ $step['done'] ? 'bg-success text-white' : 'bg-secondary text-white' }}"
                         style="width: 32px; height: 32px;">
                        @if($step['done'])
                            <i class="bi bi-check"></i>
                        @else
                            {{ bangla_number($i + 1) }}
                        @endif
                    </div>
                    <div class="{{ $step['done'] ? 'text-success fw-bold' : 'text-muted' }}">
                        {{ $step['label'] }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Info --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>আবেদনের তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th width="35%">আবেদনকারী:</th><td>{{ $application->applicant_name_bn }}</td></tr>
                    <tr><th>মোবাইল:</th><td>{{ $application->applicant_phone }}</td></tr>
                    <tr><th>NID:</th><td>{{ $application->applicant_nid ?? '-' }}</td></tr>
                    <tr><th>ওয়ার্ড:</th><td>{{ $application->ward->name_bn ?? '-' }}</td></tr>
                    <tr><th>গ্রাম:</th><td>{{ $application->village->name_bn ?? '-' }}</td></tr>
                    <tr><th>উদ্দেশ্য:</th><td>{{ $application->form_data['purpose'] ?? '-' }}</td></tr>
                    <tr><th>ফি:</th><td><strong>৳ {{ bangla_number(number_format($application->amount, 0)) }}</strong></td></tr>
                    <tr><th>পেমেন্ট:</th>
                        <td>
                            @if($application->isPaid())
                                <span class="badge bg-success">পরিশোধিত</span>
                            @else
                                <span class="badge bg-danger">বাকি</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
       @if(!$application->isPaid())
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-warning text-dark"><strong>পেমেন্ট প্রয়োজন</strong></div>
            <div class="card-body">
                <p class="small mb-2">আবেদন প্রক্রিয়া শুরু করতে ফি পরিশোধ করুন।</p>

                <a href="{{ route('applicant.payment.show', $application) }}"
                class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-credit-card"></i>
                    ৳ {{ bangla_number(number_format($application->amount, 0)) }} পরিশোধ করুন
                </a>

                @if($application->payment_method === 'cash')
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-shop"></i>
                        অথবা অফিসে গিয়ে নগদ {{ bangla_number(number_format($application->amount, 0)) }} টাকা পরিশোধ করুন।
                    </div>
                @endif
            </div>
        </div>
        @endif

        @if($application->issuedCertificate)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-success text-white"><strong>সার্টিফিকেট</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th>নম্বর:</th><td><code>{{ $application->issuedCertificate->certificate_no }}</code></td></tr>
                    <tr><th>ইস্যু:</th><td>{{ bangla_date($application->issuedCertificate->issue_date) }}</td></tr>
                    <tr><th>মেয়াদ:</th><td>{{ bangla_date($application->issuedCertificate->expiry_date) }}</td></tr>
                </table>

                @if($application->canBePrinted())
                    <a href="{{ route('applicant.applications.print', $application) }}"
                       class="btn btn-success w-100" target="_blank">
                        <i class="bi bi-printer"></i> প্রিন্ট করুন
                    </a>
                @else
                    <div class="alert alert-info small mb-2">
                        <i class="bi bi-lock"></i>
                        প্রিন্ট করা যাবে:
                        <strong>{{ bangla_date($application->print_available_at) }}</strong>
                    </div>
                    <button type="button" class="btn btn-warning btn-sm w-100"
                            data-bs-toggle="modal" data-bs-target="#earlyPrintModal">
                        <i class="bi bi-lightning"></i> তাড়াতাড়ি প্রিন্ট অনুরোধ
                    </button>
                @endif
            </div>
        </div>
        @endif

        @if($application->payment_status === 'paid')
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>রিসিট</strong></div>
            <div class="card-body">
                <a href="{{ route('applicant.applications.receipt', $application) }}"
                   class="btn btn-outline-primary w-100" target="_blank">
                    <i class="bi bi-file-earmark-text"></i> রিসিট ডাউনলোড
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Early Print Modal --}}
<div class="modal fade" id="earlyPrintModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('applicant.applications.request-early-print', $application) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">তাড়াতাড়ি প্রিন্ট অনুরোধ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">কারণ <span class="text-danger">*</span></label>
                    <textarea name="reason" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ</button>
                    <button type="submit" class="btn btn-warning">অনুরোধ পাঠান</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection