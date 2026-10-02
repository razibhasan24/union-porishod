@extends('core::layouts.app')

@section('title', 'আবেদন: ' . $application->tracking_no)

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>
        <i class="bi bi-file-earmark-text"></i>
        আবেদন — <code>{{ $application->tracking_no }}</code>
    </h4>
    <a href="{{ url()->previous() }}" class="btn btn-secondary">
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
        <strong>বর্তমান স্ট্যাটাস:</strong> {{ $status->labelBn() }}
    </div>
    <div>
        <small>{{ bangla_date($application->created_at) }}</small>
    </div>
</div>

<div class="row g-3">
    {{-- LEFT: Info --}}
    <div class="col-md-8">
        {{-- Applicant Info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>আবেদনকারীর তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th width="30%">নাম (বাংলা):</th><td>{{ $application->applicant_name_bn }}</td></tr>
                    <tr><th>পিতা:</th><td>{{ $application->applicant_father_name ?? '-' }}</td></tr>
                    <tr><th>মাতা:</th><td>{{ $application->applicant_mother_name ?? '-' }}</td></tr>
                    <tr><th>NID:</th><td>{{ $application->applicant_nid ?? '-' }}</td></tr>
                    <tr><th>মোবাইল:</th><td>{{ $application->applicant_phone }}</td></tr>
                    <tr><th>ঠিকানা:</th><td>{{ $application->applicant_address ?? '-' }}</td></tr>
                    <tr><th>ওয়ার্ড:</th><td>{{ $application->ward->name_bn ?? '-' }}</td></tr>
                    <tr><th>গ্রাম:</th><td>{{ $application->village->name_bn ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        {{-- Certificate Info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>সার্টিফিকেট তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th width="30%">ধরন:</th><td>{{ $application->certificateType->name_bn ?? '-' }}</td></tr>
                    <tr><th>উদ্দেশ্য:</th><td>{{ $application->form_data['purpose'] ?? '-' }}</td></tr>
                </table>
            </div>
        </div>

        {{-- Warish Info --}}
        @if($application->certificateType?->is_warish && $application->heirs)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>উত্তরাধিকারী তথ্য</strong></div>
            <div class="card-body">
                @if($application->deceased_info)
                <h6 class="text-muted">মৃত ব্যক্তি:</h6>
                <table class="table table-sm mb-3">
                    <tr><th width="30%">নাম:</th><td>{{ $application->deceased_info['name'] ?? '-' }}</td></tr>
                    <tr><th>মৃত্যুর তারিখ:</th><td>{{ $application->deceased_info['death_date'] ?? '-' }}</td></tr>
                </table>
                @endif

                <h6 class="text-muted">উত্তরাধিকারীবৃন্দ:</h6>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>নাম</th>
                            <th>সম্পর্ক</th>
                            <th>বয়স</th>
                            <th>NID</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($application->heirs as $heir)
                        <tr>
                            <td>{{ $heir['name'] ?? '-' }}</td>
                            <td>{{ $heir['relation'] ?? '-' }}</td>
                            <td>{{ $heir['age'] ?? '-' }}</td>
                            <td>{{ $heir['nid'] ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        {{-- Payment Info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>পেমেন্ট তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th width="30%">ফি:</th><td>৳ {{ bangla_number(number_format($application->amount, 0)) }}</td></tr>
                    <tr><th>পদ্ধতি:</th><td>{{ $application->payment_method == 'online' ? 'অনলাইন' : 'নগদ' }}</td></tr>
                    <tr><th>স্ট্যাটাস:</th>
                        <td>
                            @if($application->payment_status === 'paid')
                                <span class="badge bg-success">পরিশোধিত</span>
                            @elseif($application->payment_status === 'unpaid')
                                <span class="badge bg-danger">বাকি</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ $application->payment_status }}</span>
                            @endif
                        </td>
                    </tr>
                    @if($application->paid_at)
                    <tr><th>পরিশোধের তারিখ:</th><td>{{ bangla_date($application->paid_at) }}</td></tr>
                    @endif
                    @if($application->payment_ref)
                    <tr><th>রেফারেন্স:</th><td><code>{{ $application->payment_ref }}</code></td></tr>
                    @endif
                </table>
            </div>
        </div>

        {{-- Action History --}}
        @if($application->logs->count() > 0)
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>কার্যক্রমের ইতিহাস</strong></div>
            <div class="card-body">
                <div class="timeline">
                    @foreach($application->logs as $log)
                    <div class="border-start border-3 border-primary ps-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <strong>{{ $log->action }}</strong>
                            <small class="text-muted">{{ bangla_date($log->created_at) }}</small>
                        </div>
                        @if($log->remarks)
                            <p class="mb-1 small">{{ $log->remarks }}</p>
                        @endif
                        <small class="text-muted">
                            <i class="bi bi-person"></i>
                            {{ $log->user->name_bn ?? $log->user->name ?? 'System' }}
                        </small>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- RIGHT: Actions --}}
    <div class="col-md-4">
        {{-- Ward Member Action --}}
        @if(auth()->user()->isWardMember() && $status === \Modules\Certificate\Enums\ApplicationStatus::SENT_TO_WARD)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-warning text-dark"><strong><i class="bi bi-shield-check"></i> ওয়ার্ড সদস্যের যাচাই</strong></div>
            <div class="card-body">
                <form action="{{ route('certificate.applications.ward-recommend', $application) }}" method="POST" class="mb-2">
                    @csrf
                    <textarea name="remarks" class="form-control form-control-sm mb-2" rows="2" placeholder="মন্তব্য (ঐচ্ছিক)"></textarea>
                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-check-circle"></i> সুপারিশ করুন
                    </button>
                </form>
                <button type="button" class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="bi bi-x-circle"></i> বাতিল করুন
                </button>
            </div>
        </div>
        @endif

        {{-- Chairman Action --}}
        @if(auth()->user()->isChairman() && $status === \Modules\Certificate\Enums\ApplicationStatus::SENT_TO_CHAIRMAN)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-primary text-white"><strong><i class="bi bi-person-badge"></i> চেয়ারম্যানের অনুমোদন</strong></div>
            <div class="card-body">
                <form action="{{ route('certificate.applications.chairman-approve', $application) }}" method="POST" class="mb-2">
                    @csrf
                    <textarea name="remarks" class="form-control form-control-sm mb-2" rows="2" placeholder="মন্তব্য (ঐচ্ছিক)"></textarea>
                    <button type="submit" class="btn btn-success btn-sm w-100">
                        <i class="bi bi-check-circle"></i> অনুমোদন করুন
                    </button>
                </form>
                <button type="button" class="btn btn-warning btn-sm w-100 mb-2" data-bs-toggle="modal" data-bs-target="#holdModal">
                    <i class="bi bi-pause-circle"></i> স্থগিত করুন
                </button>
                <button type="button" class="btn btn-danger btn-sm w-100" data-bs-toggle="modal" data-bs-target="#rejectChairmanModal">
                    <i class="bi bi-x-circle"></i> বাতিল করুন
                </button>
            </div>
        </div>
        @endif

        {{-- Issued Certificate --}}
        @if($application->issuedCertificate)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-success text-white"><strong><i class="bi bi-award"></i> সার্টিফিকেট</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th>নম্বর:</th><td><code>{{ $application->issuedCertificate->certificate_no }}</code></td></tr>
                    <tr><th>ইস্যু:</th><td>{{ bangla_date($application->issuedCertificate->issue_date) }}</td></tr>
                    <tr><th>মেয়াদ:</th><td>{{ bangla_date($application->issuedCertificate->expiry_date) }}</td></tr>
                    <tr><th>প্রিন্ট:</th><td>{{ bangla_number($application->issuedCertificate->print_count) }} বার</td></tr>
                </table>
                @if($application->canBePrinted())
                    <a href="#" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-printer"></i> প্রিন্ট করুন
                    </a>
                @else
                    <div class="alert alert-info small mb-0">
                        <i class="bi bi-lock"></i>
                        প্রিন্টের অনুমতি নেই।
                        @if($application->print_available_at)
                            <br>প্রিন্ট করা যাবে: {{ bangla_date($application->print_available_at) }}
                        @endif
                    </div>
                @endif
            </div>
        </div>
        @endif

        {{-- Chairman: Allow Print --}}
        @if(auth()->user()->isChairman() && $application->issuedCertificate && !$application->canBePrinted())
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-warning text-dark"><strong><i class="bi bi-unlock"></i> প্রিন্ট অনুমতি</strong></div>
            <div class="card-body">
                <form action="{{ route('certificate.applications.allow-print', $application) }}" method="POST">
                    @csrf
                    <textarea name="reason" class="form-control form-control-sm mb-2" rows="2" placeholder="কারণ লিখুন" required></textarea>
                    <button type="submit" class="btn btn-warning btn-sm w-100">
                        <i class="bi bi-check"></i> অনুমতি দিন
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Reject Modal --}}
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('certificate.applications.ward-reject', $application) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">আবেদন বাতিল</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">বাতিলের কারণ <span class="text-danger">*</span></label>
                    <textarea name="remarks" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ</button>
                    <button type="submit" class="btn btn-danger">বাতিল করুন</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Chairman Reject Modal --}}
<div class="modal fade" id="rejectChairmanModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('certificate.applications.chairman-reject', $application) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">আবেদন বাতিল (চেয়ারম্যান)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">বাতিলের কারণ <span class="text-danger">*</span></label>
                    <textarea name="remarks" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ</button>
                    <button type="submit" class="btn btn-danger">বাতিল করুন</button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Hold Modal --}}
<div class="modal fade" id="holdModal" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('certificate.applications.chairman-hold', $application) }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">আবেদন স্থগিত</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <label class="form-label">কারণ <span class="text-danger">*</span></label>
                    <textarea name="remarks" class="form-control" rows="3" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">বন্ধ</button>
                    <button type="submit" class="btn btn-warning">স্থগিত করুন</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection