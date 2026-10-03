@extends('core::layouts.app')

@section('title', 'ধরন অনুযায়ী রিপোর্ট')

@push('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
@endpush

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-file-earmark-text"></i> ধরন অনুযায়ী রিপোর্ট</h4>
    <div>
        <a href="{{ route('report.type.pdf', ['start' => $data['start']->format('Y-m-d'), 'end' => $data['end']->format('Y-m-d')]) }}"
           class="btn btn-danger" target="_blank">
            <i class="bi bi-file-pdf"></i> PDF
        </a>
        <a href="{{ route('report.type.excel', ['start' => $data['start']->format('Y-m-d'), 'end' => $data['end']->format('Y-m-d')]) }}"
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
                <input type="date" name="start" value="{{ $data['start']->format('Y-m-d') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <input type="date" name="end" value="{{ $data['end']->format('Y-m-d') }}" class="form-control">
            </div>
            <div class="col-md-3">
                <button class="btn btn-primary"><i class="bi bi-search"></i> দেখুন</button>
            </div>
        </form>
    </div>
</div>

{{-- Chart --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-header bg-white"><strong>ধরন অনুযায়ী আবেদন</strong></div>
    <div class="card-body">
        <canvas id="typeChart" height="100"></canvas>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>ধরন</th>
                    <th class="text-end">মোট আবেদন</th>
                    <th class="text-end">অনুমোদিত</th>
                    <th class="text-end">বাতিল</th>
                    <th class="text-end">আয়</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['data'] as $i => $row)
                <tr>
                    <td>{{ bangla_number($i + 1) }}</td>
                    <td><strong>{{ $row['type']->name_bn }}</strong></td>
                    <td class="text-end">{{ bangla_number($row['total_applications']) }}</td>
                    <td class="text-end text-success">{{ bangla_number($row['approved']) }}</td>
                    <td class="text-end text-danger">{{ bangla_number($row['rejected']) }}</td>
                    <td class="text-end"><strong>৳ {{ bangla_number(number_format($row['revenue'], 0)) }}</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
new Chart(document.getElementById('typeChart'), {
    type: 'doughnut',
    data: {
        labels: @json($data['data']->pluck('type.name_bn')),
        datasets: [{
            data: @json($data['data']->pluck('total_applications')),
            backgroundColor: ['#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#06b6d4','#ec4899','#84cc16','#6366f1'],
        }]
    },
    options: { responsive: true, plugins: { legend: { position: 'right' } } }
});
</script>
@endpush