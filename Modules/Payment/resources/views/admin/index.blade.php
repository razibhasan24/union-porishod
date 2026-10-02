@extends('core::layouts.app')

@section('title', 'পেমেন্ট তালিকা')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-credit-card"></i> পেমেন্ট</h4>
    <a href="{{ route('payment.admin.cash-entry') }}" class="btn btn-primary">
        <i class="bi bi-cash-coin"></i> নগদ পেমেন্ট এন্ট্রি
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">মোট আদায়</div>
                <h3 class="mb-0 text-success">৳ {{ bangla_number(number_format($stats['total_paid'], 0)) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">আজকের আদায়</div>
                <h3 class="mb-0 text-primary">৳ {{ bangla_number(number_format($stats['today_paid'], 0)) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">আজকের সংখ্যা</div>
                <h3 class="mb-0">{{ bangla_number($stats['today_count']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">Pending Online</div>
                <h3 class="mb-0 text-warning">{{ bangla_number($stats['pending_online']) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="ট্র্যাকিং/রিসিট/মোবাইল">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">সব স্ট্যাটাস</option>
                    <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>সফল</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>অপেক্ষমাণ</option>
                    <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>ব্যর্থ</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="method" class="form-select">
                    <option value="">সব পদ্ধতি</option>
                    <option value="online" {{ request('method') == 'online' ? 'selected' : '' }}>অনলাইন</option>
                    <option value="cash" {{ request('method') == 'cash' ? 'selected' : '' }}>নগদ</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="{{ route('payment.admin.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>রিসিট/ট্র্যাকিং</th>
                        <th>আবেদনকারী</th>
                        <th>পরিমাণ</th>
                        <th>পদ্ধতি</th>
                        <th>স্ট্যাটাস</th>
                        <th>সময়</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                    <tr>
                        <td>{{ bangla_number($loop->iteration) }}</td>
                        <td>
                            <code class="small">{{ $p->receipt_no ?? $p->transaction_id }}</code><br>
                            <small class="text-muted">{{ $p->application->tracking_no ?? '-' }}</small>
                        </td>
                        <td>
                            {{ $p->application->applicant_name_bn ?? '-' }}<br>
                            <small class="text-muted">{{ $p->payer_mobile }}</small>
                        </td>
                        <td><strong>৳ {{ bangla_number(number_format($p->amount, 0)) }}</strong></td>
                        <td>
                            <span class="badge bg-info">{{ $p->method_label }}</span>
                            @if($p->gateway)
                                <br><small class="text-muted">{{ $p->gateway_label }}</small>
                            @endif
                        </td>
                        <td><span class="badge bg-{{ $p->status_color }}">{{ $p->status_label }}</span></td>
                        <td>{{ $p->paid_at ? bangla_date($p->paid_at) : '-' }}</td>
                        <td>
                            <a href="{{ route('payment.admin.show', $p) }}" class="btn btn-sm btn-info">
                                <i class="bi bi-eye"></i>
                            </a>
                            @if($p->status === 'success')
                            <a href="{{ route('payment.admin.receipt', $p) }}"
                               class="btn btn-sm btn-outline-primary" target="_blank">
                                <i class="bi bi-printer"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">কোন পেমেন্ট নেই।</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $payments->links() }}
    </div>
</div>
@endsection