@extends('core::layouts.app')

@section('title', 'ড্যাশবোর্ড')

@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট ইউনিয়ন</div>
                        <h3 class="mb-0">{{ bangla_number($stats['total_unions']) }}</h3>
                    </div>
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="bi bi-building fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট ওয়ার্ড</div>
                        <h3 class="mb-0">{{ bangla_number($stats['total_wards']) }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="bi bi-diagram-3 fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট গ্রাম</div>
                        <h3 class="mb-0">{{ bangla_number($stats['total_villages']) }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="bi bi-house-door fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-muted small">মোট ইউজার</div>
                        <h3 class="mb-0">{{ bangla_number($stats['total_users']) }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 text-info rounded p-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!empty($certificateStats))
<div class="row g-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">মোট আবেদন</div>
                <h3 class="mb-0 text-primary">{{ bangla_number($certificateStats['total_applications']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">অপেক্ষমাণ</div>
                <h3 class="mb-0 text-warning">{{ bangla_number($certificateStats['pending']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">অনুমোদিত</div>
                <h3 class="mb-0 text-success">{{ bangla_number($certificateStats['approved']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">আজকের আবেদন</div>
                <h3 class="mb-0 text-info">{{ bangla_number($certificateStats['today']) }}</h3>
            </div>
        </div>
    </div>
</div>
@endif
@endsection