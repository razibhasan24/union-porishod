@extends('core::layouts.app')

@section('title', $type->name_bn)

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>
        <span class="badge me-2" style="background: {{ $type->color ?? '#3b82f6' }};">
            <i class="bi bi-{{ $type->icon ?? 'file-text' }}"></i>
        </span>
        {{ $type->name_bn }}
    </h4>
    <div>
        @can('certificate_type.edit')
        <a href="{{ route('certificate.types.edit', $type) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> সম্পাদনা
        </a>
        @endcan
        <a href="{{ route('certificate.types.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> ফিরে যান
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>বিস্তারিত তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th width="35%">নাম (বাংলা):</th><td>{{ $type->name_bn }}</td></tr>
                    <tr><th>নাম (ইংরেজি):</th><td>{{ $type->name_en }}</td></tr>
                    <tr><th>কোড:</th><td><code>{{ $type->code ?? '-' }}</code></td></tr>
                    <tr><th>ইউনিয়ন:</th><td>{{ $type->union->name_bn ?? '-' }}</td></tr>
                    <tr><th>ফি:</th><td><strong>৳ {{ bangla_number(number_format($type->fee, 0)) }}</strong></td></tr>
                    <tr><th>নবায়ন ফি:</th><td>৳ {{ bangla_number(number_format($type->renewal_fee ?? 0, 0)) }}</td></tr>
                    <tr><th>বৈধতা:</th><td>{{ bangla_number($type->validity_days) }} দিন</td></tr>
                    <tr><th>প্রিন্ট সময়:</th>
                        <td>
                            @if($type->print_after_days == 0)
                                <span class="badge bg-success">সাথে সাথে</span>
                            @else
                                <span class="badge bg-warning text-dark">{{ bangla_number($type->print_after_days) }} দিন পর</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>সিরিয়াল ফরম্যাট:</th>
                        <td><code>{{ $type->serial_prefix }}/{{ date('Y') }}/{{ str_pad(1, $type->serial_padding, '0', STR_PAD_LEFT) }}</code></td>
                    </tr>
                    <tr><th>বর্তমান সিরিয়াল:</th><td>{{ bangla_number($type->current_serial) }}</td></tr>
                    <tr><th>ওয়ারিশ সনদ:</th>
                        <td>
                            @if($type->is_warish)
                                <span class="badge bg-info">হ্যাঁ</span>
                            @else
                                <span class="badge bg-secondary">না</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>স্ট্যাটাস:</th>
                        <td>
                            @if($type->is_active)
                                <span class="badge bg-success">সক্রিয়</span>
                            @else
                                <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>পরিসংখ্যান</strong></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>মোট আবেদন:</span>
                    <strong>{{ bangla_number($type->applications_count ?? 0) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>তৈরি:</span>
                    <strong>{{ bangla_date($type->created_at) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection