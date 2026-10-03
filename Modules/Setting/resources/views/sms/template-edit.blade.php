@extends('core::layouts.app')

@section('title', 'SMS টেমপ্লেট সম্পাদনা')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-pencil"></i> {{ $template->name_bn }}</h4>
    <a href="{{ route('setting.sms-templates.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<form action="{{ route('setting.sms-templates.update', $template) }}" method="POST">
    @csrf @method('PUT')

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label">Key</label>
                <input type="text" value="{{ $template->key }}" class="form-control" disabled>
            </div>

            <div class="mb-3">
                <label class="form-label">নাম</label>
                <input type="text" name="name_bn" value="{{ old('name_bn', $template->name_bn) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">মেসেজ (বাংলা)</label>
                <textarea name="body_bn" rows="4" class="form-control" required>{{ old('body_bn', $template->body_bn) }}</textarea>
                <small class="text-muted">
                    Variables:
                    @foreach(($template->variables ?? []) as $v)
                        <code>{{ '{' . $v . '}' }}</code>
                    @endforeach
                </small>
            </div>

            <div class="form-check mb-3">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" name="is_active" value="1" class="form-check-input"
                       id="is_active" {{ $template->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">সক্রিয়</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> সংরক্ষণ করুন
            </button>
        </div>
    </div>
</form>
@endsection