@extends('core::layouts.app')
@section('title', 'সেটিংস')
@section('content')
<h4 class="mb-3">সিস্টেম সেটিংস</h4>

<form action="{{ route('core.settings.update') }}" method="POST">
    @csrf @method('PUT')

    @forelse($settings as $group => $items)
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header bg-white"><strong>{{ ucfirst($group) }}</strong></div>
        <div class="card-body">
            @foreach($items as $s)
            <div class="mb-3">
                <label class="form-label">{{ $s->label_bn ?? $s->key }}</label>
                <input type="text" name="{{ $s->key }}" value="{{ $s->value }}" class="form-control">
            </div>
            @endforeach
        </div>
    </div>
    @empty
    <div class="alert alert-info">কোন সেটিং নেই</div>
    @endforelse

    <button class="btn btn-primary"><i class="bi bi-save"></i> সংরক্ষণ</button>
</form>
@endsection