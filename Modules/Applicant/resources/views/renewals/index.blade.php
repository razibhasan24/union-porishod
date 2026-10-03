@extends('applicant::layouts.app')

@section('title', 'নবায়ন')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-arrow-clockwise"></i> সার্টিফিকেট নবায়ন</h4>
    <a href="{{ route('applicant.dashboard') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

{{-- In Progress Renewals --}}
@if($inProgressRenewals->count() > 0)
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-warning text-dark">
        <strong><i class="bi bi-hourglass-split"></i> চলমান নবায়ন ({{ bangla_number($inProgressRenewals->count()) }})</strong>
    </div>
    <div class="card-body">
        @foreach($inProgressRenewals as $app)
            @php
                $status = $app->status instanceof \Modules\Certificate\Enums\ApplicationStatus
                    ? $app->status
                    : \Modules\Certificate\Enums\ApplicationStatus::from($app->status ?? 'draft');
            @endphp
            <div class="border rounded p-3 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $app->certificateType->name_bn ?? '-' }}</strong>
                        <span class="badge bg-info ms-2">নবায়ন</span>
                        <br>
                        <small class="text-muted">
                            <code>{{ $app->tracking_no }}</code> ·
                            মূল: <code>{{ $app->parentApplication->tracking_no ?? '-' }}</code>
                        </small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ $status->color() }}">{{ $status->labelBn() }}</span>
                        <br>
                        <a href="{{ route('applicant.applications.show', $app) }}" class="btn btn-sm btn-link">
                            বিস্তারিত <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- Renewable Certificates --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white">
        <strong><i class="bi bi-check-circle"></i> নবায়নযোগ্য সার্টিফিকেট ({{ bangla_number($renewableApplications->count()) }})</strong>
    </div>
    <div class="card-body">
        @forelse($renewableApplications as $app)
            @php
                $certificate = $app->issuedCertificate;
                $isExpired = $certificate && $certificate->expiry_date && $certificate->expiry_date->isPast();
                $daysLeft = $certificate && $certificate->expiry_date && !$isExpired
                    ? now()->diffInDays($certificate->expiry_date)
                    : 0;
            @endphp
            <div class="border rounded p-3 mb-2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $app->certificateType->name_bn ?? '-' }}</strong>
                        @if($isExpired)
                            <span class="badge bg-danger ms-2">মেয়াদ শেষ</span>
                        @else
                            <span class="badge bg-warning text-dark ms-2">
                                {{ bangla_number($daysLeft) }} দিন বাকি
                            </span>
                        @endif
                        <br>
                        <small class="text-muted">
                            <code>{{ $app->tracking_no }}</code>
                            @if($certificate)
                                · সার্টিফিকেট: <code>{{ $certificate->certificate_no }}</code>
                                · মেয়াদ: {{ bangla_date($certificate->expiry_date) }}
                            @endif
                        </small>
                    </div>
                    <div class="text-end">
                        <div class="mb-2">
                            <small class="text-muted">নবায়ন ফি:</small>
                            <strong class="text-primary">
                                ৳ {{ bangla_number(number_format($app->certificateType->renewal_fee ?? $app->certificateType->fee ?? 0, 0)) }}
                            </strong>
                        </div>
                        <a href="{{ route('applicant.applications.renew', $app) }}"
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-arrow-clockwise"></i> নবায়ন করুন
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                কোন নবায়নযোগ্য সার্টিফিকেট নেই।
                <br>
                <small>সার্টিফিকেটের মেয়াদ শেষ হওয়ার ৩০ দিন আগে বা পরে নবায়ন করা যাবে।</small>
            </div>
        @endforelse
    </div>
</div>
@endsection