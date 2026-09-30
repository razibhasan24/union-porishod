@extends('core::layouts.app')

@section('title', $union->name_bn)

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>{{ $union->name_bn }}</h4>
    <div>
        @can('union.edit')
        <a href="{{ route('core.unions.edit', $union) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> সম্পাদনা
        </a>
        @endcan
        <a href="{{ route('core.unions.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> ফিরে যান
        </a>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center">
                        @if($union->logo)
                            <img src="{{ asset('storage/' . $union->logo) }}" class="img-fluid mb-2" style="max-height: 120px;">
                        @else
                            <div class="bg-light rounded p-4 mb-2">
                                <i class="bi bi-building fs-1 text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-9">
                        <table class="table table-sm">
                            <tr><th width="35%">নাম (বাংলা):</th><td>{{ $union->name_bn }}</td></tr>
                            <tr><th>নাম (ইংরেজি):</th><td>{{ $union->name_en }}</td></tr>
                            <tr><th>কোড:</th><td><code>{{ $union->code }}</code></td></tr>
                            <tr><th>উপজেলা:</th><td>{{ $union->upazila_bn ?? '-' }}</td></tr>
                            <tr><th>জেলা:</th><td>{{ $union->district_bn ?? '-' }}</td></tr>
                            <tr><th>বিভাগ:</th><td>{{ $union->division_bn ?? '-' }}</td></tr>
                            <tr><th>ফোন:</th><td>{{ $union->phone ?? '-' }}</td></tr>
                            <tr><th>ইমেইল:</th><td>{{ $union->email ?? '-' }}</td></tr>
                            <tr><th>চেয়ারম্যান:</th><td>{{ $union->chairman_name_bn ?? '-' }}</td></tr>
                            <tr><th>প্রতিষ্ঠা:</th><td>{{ $union->established_date ? bangla_date($union->established_date) : '-' }}</td></tr>
                            <tr>
                                <th>স্ট্যাটাস:</th>
                                <td>
                                    @if($union->is_active)
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
        </div>

        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white d-flex justify-content-between">
                <strong>ওয়ার্ড তালিকা ({{ bangla_number($union->wards->count()) }})</strong>
                @can('ward.create')
                <a href="{{ route('core.wards.create', ['union_id' => $union->id]) }}" class="btn btn-sm btn-primary">
                    <i class="bi bi-plus-circle"></i> নতুন ওয়ার্ড
                </a>
                @endcan
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>ওয়ার্ড</th>
                            <th>সদস্য</th>
                            <th>মোবাইল</th>
                            <th>গ্রাম</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($union->wards as $ward)
                        <tr>
                            <td><strong>{{ $ward->name_bn }}</strong></td>
                            <td>{{ $ward->member_name_bn ?? '-' }}</td>
                            <td>{{ $ward->member_phone ?? '-' }}</td>
                            <td>{{ bangla_number($ward->villages->count()) }}</td>
                            <td>
                                <a href="{{ route('core.wards.show', $ward) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center text-muted">কোন ওয়ার্ড নেই</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>সারসংক্ষেপ</strong></div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>মোট ওয়ার্ড:</span>
                    <strong>{{ bangla_number($union->wards_count) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>মোট গ্রাম:</span>
                    <strong>{{ bangla_number($union->villages_count) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>মোট ইউজার:</span>
                    <strong>{{ bangla_number($union->users_count) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection