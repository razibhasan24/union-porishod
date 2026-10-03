@extends('applicant::layouts.app')

@section('title', 'ড্যাশবোর্ড')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট আবেদন</div>
                        <h3 class="mb-0 text-primary">{{ bangla_number($stats['total']) }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="bi bi-file-earmark-text fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">অপেক্ষমাণ</div>
                        <h3 class="mb-0 text-warning">{{ bangla_number($stats['pending']) }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="bi bi-hourglass-split fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">অনুমোদিত</div>
                        <h3 class="mb-0 text-success">{{ bangla_number($stats['approved']) }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="bi bi-check-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">বাতিল</div>
                        <h3 class="mb-0 text-danger">{{ bangla_number($stats['rejected']) }}</h3>
                    </div>
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-3">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- Renewal Alert --}}
@php
    $renewalService = app(\Modules\Certificate\Services\RenewalService::class);
    $renewable = $renewalService->getRenewableApplications(auth()->id());
@endphp

@if($renewable->count() > 0)
<div class="alert alert-warning d-flex align-items-center justify-content-between mb-3">
    <div>
        <i class="bi bi-exclamation-triangle-fill"></i>
        <strong>আপনার {{ bangla_number($renewable->count()) }}টি সার্টিফিকেটের মেয়াদ শেষ হয়েছে বা শীঘ্রই শেষ হবে।</strong>
    </div>
    <a href="{{ route('applicant.renewals.index') }}" class="btn btn-warning btn-sm">
        <i class="bi bi-arrow-clockwise"></i> নবায়ন করুন
    </a>
</div>
@endif

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <strong><i class="bi bi-clock-history"></i> সাম্প্রতিক আবেদন</strong>
        <div>
            <a href="{{ route('applicant.renewals.index') }}" class="btn btn-sm btn-outline-primary">
                <i class="bi bi-arrow-clockwise"></i> নবায়ন
            </a>
            <a href="{{ route('applicant.applications.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-circle"></i> নতুন আবেদন
            </a>
        </div>
    </div>
    <div class="card-body">
        @forelse($recentApplications as $app)
            @php
                $status = $app->status instanceof \Modules\Certificate\Enums\ApplicationStatus
                    ? $app->status
                    : \Modules\Certificate\Enums\ApplicationStatus::from($app->status ?? 'draft');
            @endphp
            <div class="border rounded p-3 mb-2 hover-bg">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $app->certificateType->name_bn ?? '-' }}</strong>
                        <br>
                        <small class="text-muted">
                            <code>{{ $app->tracking_no }}</code> ·
                            {{ bangla_date($app->created_at) }}
                        </small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-{{ $status->color() }}">{{ $status->labelBn() }}</span>
                        <br>
                        <a href="{{ route('applicant.applications.show', $app) }}"
                           class="btn btn-sm btn-link">বিস্তারিত <i class="bi bi-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center text-muted py-4">
                <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                কোন আবেদন নেই। নতুন আবেদন করতে উপরের বাটনে ক্লিক করুন।
            </div>
        @endforelse
    </div>
</div>
@endsection