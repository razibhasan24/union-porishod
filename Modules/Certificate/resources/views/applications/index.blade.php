@extends('core::layouts.app')

@section('title', 'সার্টিফিকেট আবেদন')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-file-earmark-check"></i> সার্টিফিকেট আবেদন</h4>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="ট্র্যাকিং/নাম/ফোন/NID">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>খসড়া</option>
                    <option value="sent_to_ward" {{ request('status') == 'sent_to_ward' ? 'selected' : '' }}>ওয়ার্ডে পাঠানো</option>
                    <option value="sent_to_chairman" {{ request('status') == 'sent_to_chairman' ? 'selected' : '' }}>চেয়ারম্যানে পাঠানো</option>
                    <option value="chairman_approved" {{ request('status') == 'chairman_approved' ? 'selected' : '' }}>অনুমোদিত</option>
                    <option value="ward_rejected" {{ request('status') == 'ward_rejected' ? 'selected' : '' }}>ওয়ার্ড বাতিল</option>
                    <option value="chairman_rejected" {{ request('status') == 'chairman_rejected' ? 'selected' : '' }}>চেয়ারম্যান বাতিল</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="ward_id" class="form-select">
                    <option value="">সব ওয়ার্ড</option>
                    @foreach(\Modules\Core\Models\Ward::orderBy('ward_no')->get() as $w)
                        <option value="{{ $w->id }}" {{ request('ward_id') == $w->id ? 'selected' : '' }}>
                            {{ $w->name_bn }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="{{ route('certificate.applications.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>ট্র্যাকিং</th>
                        <th>আবেদনকারী</th>
                        <th>ধরন</th>
                        <th>ওয়ার্ড</th>
                        <th>স্ট্যাটাস</th>
                        <th>তারিখ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    <tr>
                        <td>{{ bangla_number($loop->iteration + ($applications->currentPage() - 1) * $applications->perPage()) }}</td>
                        <td><code class="small">{{ $app->tracking_no }}</code></td>
                        <td>
                            <strong>{{ $app->applicant_name_bn }}</strong><br>
                            <small class="text-muted">{{ $app->applicant_phone }}</small>
                        </td>
                        <td>{{ $app->certificateType->name_bn ?? '-' }}</td>
                        <td>{{ $app->ward->name_bn ?? '-' }}</td>
                        <td>
                            @php
                                $statusVal = $app->status instanceof \Modules\Certificate\Enums\ApplicationStatus
                                    ? $app->status
                                    : \Modules\Certificate\Enums\ApplicationStatus::from($app->status ?? 'draft');
                            @endphp
                            <span class="badge bg-{{ $statusVal->color() }}">
                                {{ $statusVal->labelBn() }}
                            </span>
                        </td>
                        <td>{{ bangla_date($app->created_at) }}</td>
                        <td>
                            <a href="{{ route('certificate.applications.show', $app) }}"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            কোন আবেদন নেই।
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $applications->links() }}
    </div>
</div>
@endsection