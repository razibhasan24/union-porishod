@extends('core::layouts.app')

@section('title', 'ওয়ার্ড রিপোর্ট')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-diagram-3"></i> ওয়ার্ড রিপোর্ট</h4>
    <div>
        <a href="{{ route('report.ward.pdf', ['start' => $data['start']->format('Y-m-d'), 'end' => $data['end']->format('Y-m-d')]) }}"
           class="btn btn-danger" target="_blank">
            <i class="bi bi-file-pdf"></i> PDF
        </a>
        <a href="{{ route('report.ward.excel', ['start' => $data['start']->format('Y-m-d'), 'end' => $data['end']->format('Y-m-d')]) }}"
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

{{-- Summary --}}
<div class="row g-3 mb-3">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="small">মোট আবেদন</div>
                <h3 class="mb-0">{{ bangla_number($data['totals']['applications']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <div class="small">অনুমোদিত</div>
                <h3 class="mb-0">{{ bangla_number($data['totals']['approved']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-danger text-white">
            <div class="card-body">
                <div class="small">বাতিল</div>
                <h3 class="mb-0">{{ bangla_number($data['totals']['rejected']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <div class="small">মোট আয়</div>
                <h3 class="mb-0">৳ {{ bangla_number(number_format($data['totals']['revenue'], 0)) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>ওয়ার্ড</th>
                        <th class="text-end">মোট আবেদন</th>
                        <th class="text-end">অনুমোদিত</th>
                        <th class="text-end">বাতিল</th>
                        <th class="text-end">অপেক্ষমাণ</th>
                        <th class="text-end">আয়</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['data'] as $i => $row)
                    <tr>
                        <td>{{ bangla_number($i + 1) }}</td>
                        <td><strong>{{ $row['ward']->name_bn }}</strong></td>
                        <td class="text-end">{{ bangla_number($row['total_applications']) }}</td>
                        <td class="text-end text-success">{{ bangla_number($row['approved']) }}</td>
                        <td class="text-end text-danger">{{ bangla_number($row['rejected']) }}</td>
                        <td class="text-end text-warning">{{ bangla_number($row['pending']) }}</td>
                        <td class="text-end"><strong>৳ {{ bangla_number(number_format($row['revenue'], 0)) }}</strong></td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <th colspan="2">মোট</th>
                        <th class="text-end">{{ bangla_number($data['totals']['applications']) }}</th>
                        <th class="text-end">{{ bangla_number($data['totals']['approved']) }}</th>
                        <th class="text-end">{{ bangla_number($data['totals']['rejected']) }}</th>
                        <th class="text-end">-</th>
                        <th class="text-end">৳ {{ bangla_number(number_format($data['totals']['revenue'], 0)) }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
@endsection