@extends('core::layouts.app')

@section('title', 'মাসিক রিপোর্ট')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-calendar-month"></i> মাসিক রিপোর্ট</h4>
    <div>
        <a href="{{ route('report.monthly.pdf', ['year' => $data['year'], 'month' => $data['month']]) }}"
           class="btn btn-danger" target="_blank">
            <i class="bi bi-file-pdf"></i> PDF
        </a>
        <a href="{{ route('report.monthly.excel', ['year' => $data['year'], 'month' => $data['month']]) }}"
           class="btn btn-success">
            <i class="bi bi-file-excel"></i> Excel
        </a>
    </div>
</div>

{{-- Month Filter --}}
<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-3">
                <select name="year" class="form-select">
                    @for($y = now()->year; $y >= 2020; $y--)
                        <option value="{{ $y }}" {{ $data['year'] == $y ? 'selected' : '' }}>{{ bangla_number($y) }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-4">
                <select name="month" class="form-select">
                    @foreach(['জানুয়ারি','ফেব্রুয়ারি','মার্চ','এপ্রিল','মে','জুন','জুলাই','আগস্ট','সেপ্টেম্বর','অক্টোবর','নভেম্বর','ডিসেম্বর'] as $i => $name)
                        <option value="{{ $i + 1 }}" {{ $data['month'] == $i + 1 ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-primary w-100"><i class="bi bi-search"></i> দেখুন</button>
            </div>
        </form>
    </div>
</div>

{{-- Summary Cards --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="small">মোট আবেদন</div>
                <h3 class="mb-0">{{ bangla_number($data['applications']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="small">অনুমোদিত</div>
                <h3 class="mb-0">{{ bangla_number($data['approved']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-danger text-white">
            <div class="card-body">
                <div class="small">বাতিল</div>
                <h3 class="mb-0">{{ bangla_number($data['rejected']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="small">মোট আয়</div>
                <h3 class="mb-0">৳ {{ bangla_number(number_format($data['revenue'], 0)) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    {{-- By Type --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>ধরন অনুযায়ী আবেদন</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr><th>ধরন</th><th class="text-end">সংখ্যা</th></tr>
                    </thead>
                    <tbody>
                        @foreach($data['by_type'] as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td class="text-end">{{ bangla_number($row['total']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- By Ward --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>ওয়ার্ড অনুযায়ী আবেদন</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <thead>
                        <tr><th>ওয়ার্ড</th><th class="text-end">সংখ্যা</th></tr>
                    </thead>
                    <tbody>
                        @foreach($data['by_ward'] as $row)
                        <tr>
                            <td>{{ $row['name'] }}</td>
                            <td class="text-end">{{ bangla_number($row['total']) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Daily Breakdown --}}
<div class="card border-0 shadow-sm">
    <div class="card-header bg-white"><strong>দিন অনুযায়ী আবেদন</strong></div>
    <div class="card-body">
        <table class="table table-sm mb-0">
            <thead>
                <tr><th>তারিখ</th><th class="text-end">আবেদন</th></tr>
            </thead>
            <tbody>
                @foreach($data['daily_breakdown'] as $row)
                <tr>
                    <td>{{ bangla_date($row->date) }}</td>
                    <td class="text-end">{{ bangla_number($row->total) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection