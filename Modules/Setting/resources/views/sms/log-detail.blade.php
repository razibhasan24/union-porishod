@extends('core::layouts.app')

@section('title', 'SMS বিস্তারিত')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-chat-dots"></i> SMS বিস্তারিত</h4>
    <a href="{{ route('setting.sms-logs.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body">
        <table class="table table-sm">
            <tr><th width="25%">মোবাইল:</th><td>{{ $log->mobile }}</td></tr>
            <tr><th>স্ট্যাটাস:</th>
                <td><span class="badge bg-{{ $log->status_color }}">{{ $log->status_label }}</span></td>
            </tr>
            <tr><th>টেমপ্লেট:</th><td>{{ $log->template_key ?? '-' }}</td></tr>
            <tr><th>গেটওয়ে:</th><td>{{ $log->gateway ?? '-' }}</td></tr>
            <tr><th>Reference:</th><td>{{ $log->reference_id ?? '-' }}</td></tr>
            <tr><th>পাঠানোর সময়:</th><td>{{ $log->sent_at ? bangla_date($log->sent_at) : '-' }}</td></tr>
            <tr><th>তৈরি:</th><td>{{ bangla_date($log->created_at) }}</td></tr>
            <tr><th>মেসেজ:</th>
                <td>
                    <div class="border rounded p-2 bg-light">{{ $log->message }}</div>
                </td>
            </tr>
            @if($log->response)
            <tr>
                <th>Gateway Response:</th>
                <td><pre class="small mb-0">{{ $log->response }}</pre></td>
            </tr>
            @endif
            @if($log->error_message)
            <tr>
                <th>Error:</th>
                <td><span class="text-danger">{{ $log->error_message }}</span></td>
            </tr>
            @endif
        </table>
    </div>
</div>
@endsection