@extends('core::layouts.app')
@section('title', $ward->name_bn)
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>{{ $ward->name_bn }}</h4>
    <a href="{{ route('core.wards.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>ওয়ার্ড তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th>ওয়ার্ড নম্বর:</th><td>{{ bangla_number($ward->ward_no) }}</td></tr>
                    <tr><th>ইউনিয়ন:</th><td>{{ $ward->union->name_bn ?? '-' }}</td></tr>
                    <tr><th>সদস্য:</th><td>{{ $ward->member_name_bn ?? '-' }}</td></tr>
                    <tr><th>মোবাইল:</th><td>{{ $ward->member_phone ?? '-' }}</td></tr>
                    <tr><th>গ্রাম সংখ্যা:</th><td>{{ bangla_number($ward->villages->count()) }}</td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>গ্রাম তালিকা</strong></div>
            <div class="card-body">
                <ul class="list-group">
                    @forelse($ward->villages as $v)
                        <li class="list-group-item d-flex justify-content-between">
                            {{ $v->name_bn }}
                            <small class="text-muted">{{ $v->post_code ?? '' }}</small>
                        </li>
                    @empty
                        <li class="list-group-item text-muted text-center">কোন গ্রাম নেই</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection