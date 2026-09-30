@extends('core::layouts.app')

@section('title', 'ইউনিয়ন তালিকা')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>ইউনিয়ন তালিকা</h4>
    @can('union.create')
    <a href="{{ route('core.unions.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> নতুন ইউনিয়ন
    </a>
    @endcan
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>নাম (বাংলা)</th>
                    <th>কোড</th>
                    <th>উপজেলা</th>
                    <th>ওয়ার্ড</th>
                    <th>স্ট্যাটাস</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($unions as $union)
                <tr>
                    <td>{{ bangla_number($loop->iteration) }}</td>
                    <td>
                        <strong>{{ $union->name_bn }}</strong><br>
                        <small class="text-muted">{{ $union->name_en }}</small>
                    </td>
                    <td><code>{{ $union->code }}</code></td>
                    <td>{{ $union->upazila_bn ?? '-' }}</td>
                    <td><span class="badge bg-info">{{ bangla_number($union->wards_count) }}</span></td>
                    <td>
                        @if($union->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('core.unions.show', $union) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        @can('union.edit')
                        <a href="{{ route('core.unions.edit', $union) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">
                        কোন ইউনিয়ন পাওয়া যায়নি।
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{ $unions->links() }}
    </div>
</div>
@endsection