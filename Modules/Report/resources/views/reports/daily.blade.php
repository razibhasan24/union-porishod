@extends('core::layouts.app')

@section('title', 'দৈনিক রিপোর্ট')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-calendar-day"></i> দৈনিক রিপোর্ট</h4>
    <div>
        <a href="{{ route('report.daily.pdf', ['date' => $data['date']->format('Y-m-d')]) }}"
           class="btn btn-danger" target="_blank">
            <i class="bi bi-file-pdf"></i> PDF
        </a>
        <a href="{{ route('report.daily.excel', ['date' => $data['date']->format('Y-m-d')]) }}"
           class="btn btn-success">
            <i class="bi bi-file-excel"></i> Excel
        </a>
    </div>
</div>

{{-- Date Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <input type="date" name="date" value="{{ $data['date']->format('Y-m-d') }}" class="form-control">
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> দেখুন</button>
            </div>
        </form>
    </div>
</div>

{{-- Summary --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-muted">আবেদন</div>
                <h3 class="text-primary">{{ bangla_number($data['applications']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-muted">পেমেন্ট</div>
                <h3 class="text-success">{{ bangla_number($data['paid']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-muted">অনুমোদিত</div>
                <h3 class="text-info">{{ bangla_number($data['approved']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
                <div class="text-muted">আয়</div>
                <h3 class="text-warning">৳ {{ bangla_number(number_format($data['revenue'], 0)) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    {{-- By Type --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>ধরন অনুযায়ী</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr>
                            <th>ধরন</th>
                            <th class="text-end">সংখ্যা</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data['by_type'] as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td class="text-end"><strong>{{ bangla_number($row['total']) }}</strong></td>
                        </tr>
                        @empty
                        <tr><td colspan="2" class="text-center text-muted">কোন তথ্য নেই</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Payment Method --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>পেমেন্ট পদ্ধতি</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr>
                        <th>অনলাইন</th>
                        <td class="text-end">৳ {{ bangla_number(number_format($data['by_method']['online'], 0)) }}</td>
                    </tr>
                    <tr>
                        <th>নগদ</th>
                        <td class="text-end">৳ {{ bangla_number(number_format($data['by_method']['cash'], 0)) }}</td>
                    </tr>
                    <tr class="table-light">
                        <th>মোট</th>
                        <td class="text-end"><strong>৳ {{ bangla_number(number_format($data['revenue'], 0)) }}</strong></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="text-center text-muted mt-3">
    তারিখ: <strong>{{ bangla_date($data['date']) }}</strong>
</div>
@endsection