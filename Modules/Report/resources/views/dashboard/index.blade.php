@extends('core::layouts.app')

@section('title', 'রিপোর্ট ড্যাশবোর্ড')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<h4 class="mb-3"><i class="bi bi-graph-up"></i> রিপোর্ট ড্যাশবোর্ড</h4>

{{-- Today Stats --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-primary">
            <div class="card-body">
                <div class="text-muted small">আজকের আবেদন</div>
                <h3 class="mb-0 text-primary">{{ bangla_number($stats['today']['applications']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-success">
            <div class="card-body">
                <div class="text-muted small">আজকের অনুমোদন</div>
                <h3 class="mb-0 text-success">{{ bangla_number($stats['today']['approved']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-warning">
            <div class="card-body">
                <div class="text-muted small">আজকের প্রিন্ট</div>
                <h3 class="mb-0 text-warning">{{ bangla_number($stats['today']['printed']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm border-start border-4 border-info">
            <div class="card-body">
                <div class="text-muted small">আজকের আয়</div>
                <h3 class="mb-0 text-info">৳ {{ bangla_number(number_format($stats['today']['revenue'], 0)) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Month Stats --}}
<div class="row g-3 mb-3">
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">এই মাসের আবেদন</div>
                <h3 class="mb-0">{{ bangla_number($stats['this_month']['applications']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">এই মাসের অনুমোদন</div>
                <h3 class="mb-0 text-success">{{ bangla_number($stats['this_month']['approved']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="text-muted small">এই মাসের আয়</div>
                <h3 class="mb-0 text-primary">৳ {{ bangla_number(number_format($stats['this_month']['revenue'], 0)) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Total Stats --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="small opacity-75">মোট আবেদন</div>
                <h3 class="mb-0">{{ bangla_number($stats['total']['applications']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="small opacity-75">মোট অনুমোদিত</div>
                <h3 class="mb-0">{{ bangla_number($stats['total']['approved']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body">
                <div class="small opacity-75">অপেক্ষমাণ</div>
                <h3 class="mb-0">{{ bangla_number($stats['total']['pending']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="small opacity-75">মোট আয়</div>
                <h3 class="mb-0">৳ {{ bangla_number(number_format($stats['total']['revenue'], 0)) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Chart --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white"><strong>শেষ ৩০ দিনের আবেদন ও আয়</strong></div>
    <div class="card-body">
        <canvas id="trendChart" height="80"></canvas>
    </div>
</div>

{{-- Quick Links --}}
<div class="row g-3">
    <div class="col-md-3">
        <a href="{{ route('report.daily') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm text-center p-4">
                <i class="bi bi-calendar-day fs-1 text-primary"></i>
                <h6 class="mt-2 mb-0">দৈনিক রিপোর্ট</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('report.monthly') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm text-center p-4">
                <i class="bi bi-calendar-month fs-1 text-success"></i>
                <h6 class="mt-2 mb-0">মাসিক রিপোর্ট</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('report.revenue') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm text-center p-4">
                <i class="bi bi-cash-coin fs-1 text-warning"></i>
                <h6 class="mt-2 mb-0">আয়ের রিপোর্ট</h6>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('report.ward') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm text-center p-4">
                <i class="bi bi-diagram-3 fs-1 text-info"></i>
                <h6 class="mt-2 mb-0">ওয়ার্ড রিপোর্ট</h6>
            </div>
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
const ctx = document.getElementById('trendChart');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: @json(array_column($last30Days, 'date')),
        datasets: [
            {
                label: 'আবেদন',
                data: @json(array_column($last30Days, 'applications')),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                tension: 0.3,
                yAxisID: 'y',
            },
            {
                label: 'আয় (৳)',
                data: @json(array_column($last30Days, 'revenue')),
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                tension: 0.3,
                yAxisID: 'y1',
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        scales: {
            y: { type: 'linear', display: true, position: 'left', title: { display: true, text: 'আবেদন' } },
            y1: { type: 'linear', display: true, position: 'right', title: { display: true, text: 'আয় (৳)' }, grid: { drawOnChartArea: false } }
        }
    }
});
</script>
@endpush