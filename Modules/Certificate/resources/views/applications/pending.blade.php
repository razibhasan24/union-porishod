@extends('core::layouts.app')

@section('title', 'যাচাইয়ের অপেক্ষায়')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>
        <i class="bi bi-hourglass-split text-warning"></i>
        যাচাইয়ের অপেক্ষায় ({{ bangla_number($applications->total()) }})
    </h4>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>ট্র্যাকিং</th>
                        <th>আবেদনকারী</th>
                        <th>ধরন</th>
                        <th>পেমেন্ট</th>
                        <th>তারিখ</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                    <tr>
                        <td>{{ bangla_number($loop->iteration) }}</td>
                        <td><code class="small">{{ $app->tracking_no }}</code></td>
                        <td>
                            <strong>{{ $app->applicant_name_bn }}</strong><br>
                            <small>{{ $app->applicant_phone }}</small>
                        </td>
                        <td>{{ $app->certificateType->name_bn ?? '-' }}</td>
                        <td>
                            @if($app->payment_status === 'paid')
                                <span class="badge bg-success">পরিশোধিত</span>
                            @else
                                <span class="badge bg-danger">বাকি</span>
                            @endif
                        </td>
                        <td>{{ bangla_date($app->created_at) }}</td>
                        <td>
                            <a href="{{ route('certificate.applications.show', $app) }}"
                               class="btn btn-sm btn-primary">
                                <i class="bi bi-eye"></i> যাচাই করুন
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted py-4">
                            <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                            কোন আবেদন যাচাইয়ের অপেক্ষায় নেই।
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