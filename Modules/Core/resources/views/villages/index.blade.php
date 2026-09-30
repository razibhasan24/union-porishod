@extends('core::layouts.app')
@section('title', 'গ্রাম তালিকা')
@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>গ্রাম তালিকা</h4>
    @can('village.create')
    <a href="{{ route('core.villages.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> নতুন গ্রাম</a>
    @endcan
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>গ্রাম</th>
                    <th>ইউনিয়ন</th>
                    <th>ওয়ার্ড</th>
                    <th>জনসংখ্যা</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($villages as $v)
                <tr>
                    <td>{{ bangla_number($loop->iteration) }}</td>
                    <td><strong>{{ $v->name_bn }}</strong></td>
                    <td>{{ $v->union->name_bn ?? '-' }}</td>
                    <td>{{ $v->ward->name_bn ?? '-' }}</td>
                    <td>{{ bangla_number($v->population) }}</td>
                    <td>
                        <a href="{{ route('core.villages.show', $v) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        @can('village.edit')
                        <a href="{{ route('core.villages.edit', $v) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted py-4">কোন গ্রাম নেই</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $villages->links() }}
    </div>
</div>
@endsection