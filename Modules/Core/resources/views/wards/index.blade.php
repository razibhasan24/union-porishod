@extends('core::layouts.app')

@section('title', 'ওয়ার্ড তালিকা')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>ওয়ার্ড তালিকা</h4>
    @can('ward.create')
    <a href="{{ route('core.wards.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> নতুন ওয়ার্ড
    </a>
    @endcan
</div>

<div class="card border-0 shadow-sm mb-3">
    <div class="card-body">
        <form method="GET" class="row g-2">
            <div class="col-md-4">
                <select name="union_id" class="form-select">
                    <option value="">সব ইউনিয়ন</option>
                    @foreach($unions as $u)
                        <option value="{{ $u->id }}" {{ request('union_id') == $u->id ? 'selected' : '' }}>
                            {{ $u->name_bn }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="খুঁজুন...">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="{{ route('core.wards.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>ওয়ার্ড</th>
                    <th>ইউনিয়ন</th>
                    <th>সদস্য</th>
                    <th>মোবাইল</th>
                    <th>গ্রাম</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wards as $ward)
                <tr>
                    <td>{{ bangla_number($loop->iteration) }}</td>
                    <td><strong>{{ $ward->name_bn }}</strong></td>
                    <td>{{ $ward->union->name_bn ?? '-' }}</td>
                    <td>{{ $ward->member_name_bn ?? '-' }}</td>
                    <td>{{ $ward->member_phone ?? '-' }}</td>
                    <td><span class="badge bg-info">{{ bangla_number($ward->villages->count()) }}</span></td>
                    <td>
                        <a href="{{ route('core.wards.show', $ward) }}" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        @can('ward.edit')
                        <a href="{{ route('core.wards.edit', $ward) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        @endcan
                        @can('ward.delete')
                        <form action="{{ route('core.wards.destroy', $ward) }}" method="POST" class="d-inline" onsubmit="return confirm('নিশ্চিত?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                        </form>
                        @endcan
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center text-muted py-4">কোন ওয়ার্ড নেই</td></tr>
                @endforelse
            </tbody>
        </table>
        {{ $wards->links() }}
    </div>
</div>
@endsection