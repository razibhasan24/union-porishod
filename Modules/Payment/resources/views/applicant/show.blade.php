@extends('applicant::layouts.app')

@section('title', 'পেমেন্ট')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-credit-card"></i> পেমেন্ট</h4>
    <a href="{{ route('applicant.applications.show', $application) }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<div class="row g-3">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>পেমেন্ট পদ্ধতি নির্বাচন করুন</strong></div>
            <div class="card-body">
                <form action="{{ route('applicant.payment.initiate', $application) }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">গেটওয়ে</label>
                        @foreach($gateways as $key => $gw)
                        <div class="form-check mb-2 border rounded p-3 gateway-option"
                             style="cursor: pointer;">
                            <input type="radio" name="gateway" value="{{ $key }}"
                                   id="gw_{{ $key }}" class="form-check-input"
                                   {{ $loop->first ? 'checked' : '' }} required>
                            <label class="form-check-label d-flex align-items-center w-100" for="gw_{{ $key }}">
                                <span class="badge me-2" style="background: {{ $gw['color'] }}; padding: 8px 12px;">
                                    <i class="bi bi-phone"></i>
                                </span>
                                <strong>{{ $gw['name'] }}</strong>
                            </label>
                        </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <label class="form-label">মোবাইল নম্বর <span class="text-danger">*</span></label>
                        <input type="text" name="mobile" value="{{ old('mobile', auth()->user()->phone) }}"
                               class="form-control" required placeholder="01XXXXXXXXX">
                        <small class="text-muted">যে নম্বর থেকে পেমেন্ট করবেন</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-lock-fill"></i>
                        ৳ {{ bangla_number(number_format($application->amount, 0)) }} পরিশোধ করুন
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white"><strong>আবেদনের তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th>ট্র্যাকিং:</th><td><code>{{ $application->tracking_no }}</code></td></tr>
                    <tr><th>সার্টিফিকেট:</th><td>{{ $application->certificateType->name_bn ?? '-' }}</td></tr>
                    <tr><th>আবেদনকারী:</th><td>{{ $application->applicant_name_bn }}</td></tr>
                    <tr><th>ফি:</th>
                        <td><strong class="text-primary">৳ {{ bangla_number(number_format($application->amount, 0)) }}</strong></td>
                    </tr>
                </table>

                <div class="alert alert-info small mb-0">
                    <i class="bi bi-info-circle"></i>
                    পেমেন্ট সম্পন্ন হলে আপনার আবেদন স্বয়ংক্রিয়ভাবে ওয়ার্ড সদস্যের কাছে যাবে।
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-3">
            <div class="card-body text-center">
                <small class="text-muted">অথবা</small>
                <p class="small mb-2">অফিসে গিয়ে নগদ পেমেন্ট করতে চান?</p>
                <div class="alert alert-warning small mb-0">
                    <i class="bi bi-shop"></i>
                    ইউনিয়ন পরিষদ অফিসে গিয়ে ট্র্যাকিং নম্বর <strong>{{ $application->tracking_no }}</strong> বলে
                    ৳ {{ bangla_number(number_format($application->amount, 0)) }} পরিশোধ করুন।
                </div>
            </div>
        </div>
    </div>
</div>
@endsection