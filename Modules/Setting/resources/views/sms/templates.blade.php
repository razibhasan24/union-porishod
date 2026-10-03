@extends('core::layouts.app')

@section('title', 'SMS টেমপ্লেট')

@section('content')
<h4 class="mb-3"><i class="bi bi-file-earmark-text"></i> SMS টেমপ্লেট</h4>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Key</th>
                    <th>নাম</th>
                    <th>স্ট্যাটাস</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($templates as $t)
                <tr>
                    <td>{{ bangla_number($loop->iteration) }}</td>
                    <td><code>{{ $t->key }}</code></td>
                    <td>{{ $t->name_bn }}</td>
                    <td>
                        @if($t->is_active)
                            <span class="badge bg-success">সক্রিয়</span>
                        @else
                            <span class="badge bg-secondary">নিষ্ক্রিয়</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('setting.sms-templates.edit', $t) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i> সম্পাদনা
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $templates->links() }}
    </div>
</div>
@endsection