@extends('core::layouts.app')

@section('title', 'SMS লগ')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-chat-dots"></i> SMS লগ</h4>
    <a href="{{ route('setting.sms-send.form') }}" class="btn btn-primary">
        <i class="bi bi-send"></i> নতুন SMS পাঠান
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">মোট</div>
                <h3 class="mb-0">{{ bangla_number($stats['total']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">পাঠানো</div>
                <h3 class="mb-0 text-success">{{ bangla_number($stats['sent']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">ব্যর্থ</div>
                <h3 class="mb-0 text-danger">{{ bangla_number($stats['failed']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">আজ</div>
                <h3 class="mb-0 text-primary">{{ bangla_number($stats['today']) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="মোবাইল / মেসেজ / টেমপ্লেট">
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>পাঠানো</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>অপেক্ষমাণ</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>ব্যর্থ</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="{{ route('setting.sms-logs.index') }}" class="btn btn-secondary">Reset</a>
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
                        <th>মোবাইল</th>
                        <th>মেসেজ</th>
                        <th>টেমপ্লেট</th>
                        <th>গেটওয়ে</th>
                        <th>স্ট্যাটাস</th>
                        <th>সময়</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td>{{ bangla_number($loop->iteration + ($logs->currentPage() - 1) * $logs->perPage()) }}</td>
                        <td>{{ $log->mobile }}</td>
                        <td>
                            <small>{{ \Illuminate\Support\Str::limit($log->message, 60) }}</small>
                        </td>
                        <td><span class="badge bg-secondary">{{ $log->template_key ?? '-' }}</span></td>
                        <td><span class="badge bg-info">{{ $log->gateway ?? '-' }}</span></td>
                        <td>
                            <span class="badge bg-{{ $log->status_color }}">{{ $log->status_label }}</span>
                        </td>
                        <td>
                            <small>{{ bangla_date($log->created_at) }}</small>
                        </td>
                        <td>
                            <a href="{{ route('setting.sms-logs.show', $log) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">কোন লগ নেই</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $logs->links() }}
    </div>
</div>
@endsection