@extends('core::layouts.app')

@section('title', 'আয়ের রিপোর্ট')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-cash-coin"></i> আয়ের রিপোর্ট</h4>
    <div>
        <a href="{{ route('report.revenue.pdf', ['start' => $data['start']->format('Y-m-d'), 'end' => $data['end']->format('Y-m-d')]) }}"
           class="btn btn-danger" target="_blank">
            <i class="bi bi-file-pdf"></i> PDF
        </a>
        <a href="{{ route('report.revenue.excel', ['start' => $data['start']->format('Y-m-d'), 'end' => $data['end']->format('Y-m-d')]) }}"
           class="btn btn-success">
            <i class="bi bi-file-excel"></i> Excel
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <label class="form-label small mb-1">শুরুর তারিখ</label>
                <input type="date" name="start" value="{{ $data['start']->format('Y-m-d') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label small mb-1">শেষ তারিখ</label>
                <input type="date" name="end" value="{{ $data['end']->format('Y-m-d') }}" class="form-control">
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button class="btn btn-primary"><i class="bi bi-search"></i> দেখুন</button>
            </div>
        </form>
    </div>
</div>

{{-- Summary --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="small">মোট আয়</div>
                <h3 class="mb-0">৳ {{ bangla_number(number_format($data['total_revenue'], 0)) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="small">অনলাইন</div>
                <h3 class="mb-0">৳ {{ bangla_number(number_format($data['by_method']['online'], 0)) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="small">নগদ</div>
                <h3 class="mb-0">৳ {{ bangla_number(number_format($data['by_method']['cash'], 0)) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body">
                <div class="small">নেট আয়</div>
                <h3 class="mb-0">৳ {{ bangla_number(number_format($data['net_revenue'], 0)) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Chart --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white"><strong>দিন অনুযায়ী আয়</strong></div>
    <div class="card-body">
        <canvas id="revenueChart" height="80"></canvas>
    </div>
</div>

{{-- By Gateway --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><strong>পেমেন্ট পদ্ধতি অনুযায়ী</strong></div>
    <div class="card-body">
        <table class="table table-sm mb-0">
            <thead>
                <tr>
                    <th>পদ্ধতি</th>
                    <th class="text-end">সংখ্যা</th>
                    <th class="text-end">পরিমাণ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['by_gateway'] as $row)
                <tr>
                    <td>{{ $row->gateway ?? 'Unknown' }}</td>
                    <td class="text-end">{{ bangla_number($row->count) }}</td>
                    <td class="text-end"><strong>৳ {{ bangla_number(number_format($row->total, 0)) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx2 = document.getElementById('revenueChart');
new Chart(ctx2, {
    type: 'bar',
    data: {
        labels: @json($data['by_day']->pluck('date')),
        datasets: [{
            label: 'আয় (৳)',
            data: @json($data['by_day']->pluck('total')),
            backgroundColor: '#10b981',
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
    }
});
</script>
@endpush