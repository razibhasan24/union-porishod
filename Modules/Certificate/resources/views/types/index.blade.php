@extends('core::layouts.app')

@section('title', 'সার্টিফিকেট ধরন')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-file-earmark-text"></i> সার্টিফিকেট ধরন</h4>
    @can('certificate_type.create')
    <a href="{{ route('certificate.types.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> নতুন ধরন
    </a>
    @endcan
</div>

{{-- Filter --}}
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
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="নাম বা কোড দিয়ে খুঁজুন...">
            </div>
            <div class="col-md-4">
                <button class="btn btn-primary"><i class="bi bi-search"></i> খুঁজুন</button>
                <a href="{{ route('certificate.types.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card border-0 shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>নাম</th>
                        <th>কোড</th>
                        <th>ফি</th>
                        <th>বৈধতা</th>
                        <th>প্রিন্ট</th>
                        <th>স্ট্যাটাস</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                    <tr>
                        <td>{{ bangla_number($loop->iteration + ($types->currentPage() - 1) * $types->perPage()) }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                @if($type->icon)
                                    <span class="badge me-2" style="background: {{ $type->color ?? '#3b82f6' }};">
                                        <i class="bi bi-{{ $type->icon }}"></i>
                                    </span>
                                @endif
                                <div>
                                    <strong>{{ $type->name_bn }}</strong>
                                    @if($type->is_warish)
                                        <span class="badge bg-purple ms-1" style="background:#8b5cf6;">ওয়ারিশ</span>
                                    @endif
                                    <br>
                                    <small class="text-muted">{{ $type->name_en }}</small>
                                </div>
                            </div>
                        </td>
                        <td><code>{{ $type->code }}</code></td>
                        <td><strong>৳ {{ bangla_number(number_format($type->fee, 0)) }}</strong></td>
                        <td>{{ bangla_number($type->validity_days) }} দিন</td>
                        <td>
                            @if($type->print_after_days == 0)
                                <span class="badge bg-success">সাথে সাথে</span>
                            @else
                                <span class="badge bg-warning text-dark">
                                    {{ bangla_number($type->print_after_days) }} দিন পর
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($type->is_active)
                                <span class="badge bg-success">সক্রিয়</span>
                            @else
                                <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('certificate.types.show', $type) }}"
                                   class="btn btn-info" title="দেখুন">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @can('certificate_type.edit')
                                <a href="{{ route('certificate.types.edit', $type) }}"
                                   class="btn btn-warning" title="সম্পাদনা">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                                @can('certificate_type.delete')
                                <form action="{{ route('certificate.types.destroy', $type) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('নিশ্চিত ডিলিট করবেন?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger" title="ডিলিট">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            কোন সার্টিফিকেটের ধরন নেই।
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $types->links() }}
    </div>
</div>
@endsection