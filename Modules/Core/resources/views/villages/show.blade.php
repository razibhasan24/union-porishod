@extends('core::layouts.app')
@section('title', $village->name_bn)
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>{{ $village->name_bn }}</h4>
    <a href="{{ route('core.villages.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> ফিরে যান</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-sm">
            <tr><th width="30%">নাম (বাংলা):</th><td>{{ $village->name_bn }}</td></tr>
            <tr><th>নাম (ইংরেজি):</th><td>{{ $village->name_en ?? '-' }}</td></tr>
            <tr><th>ইউনিয়ন:</th><td>{{ $village->union->name_bn ?? '-' }}</td></tr>
            <tr><th>ওয়ার্ড:</th><td>{{ $village->ward->name_bn ?? '-' }}</td></tr>
            <tr><th>পোস্ট অফিস:</th><td>{{ $village->post_office ?? '-' }}</td></tr>
            <tr><th>পোস্ট কোড:</th><td>{{ $village->post_code ?? '-' }}</td></tr>
            <tr><th>জনসংখ্যা:</th><td>{{ bangla_number($village->population) }}</td></tr>
        </table>
    </div>
</div>
@endsection