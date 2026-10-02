@extends('applicant::layouts.app')

@section('title', 'আমার আবেদন')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-file-earmark-text"></i> আমার আবেদন</h4>
    <a href="{{ route('applicant.applications.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> নতুন আবেদন
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>ট্র্যাকিং</th>
                        <th>ধরন</th>
                        <th>স্ট্যাটাস</th>
                        <th>তারিখ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    @php
                        $status = $app->status instanceof \Modules\Certificate\Enums\ApplicationStatus
                            ? $app->status
                            : \Modules\Certificate\Enums\ApplicationStatus::from($app->status ?? 'draft');
                    @endphp
                    <tr>
                        <td>{{ bangla_number($loop->iteration + ($applications->currentPage() - 1) * $applications->perPage()) }}</td>
                        <td><code class="small">{{ $app->tracking_no }}</code></td>
                        <td>{{ $app->certificateType->name_bn ?? '-' }}</td>
                        <td><span class="badge bg-{{ $status->color() }}">{{ $status->labelBn() }}</span></td>
                        <td>{{ bangla_date($app->created_at) }}</td>
                        <td>
                            <a href="{{ route('applicant.applications.show', $app) }}"
                               class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i> দেখুন
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
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