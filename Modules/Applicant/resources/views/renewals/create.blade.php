@extends('applicant::layouts.app')

@section('title', 'নবায়ন করুন')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-arrow-clockwise"></i> সার্টিফিকেট নবায়ন</h4>
    <a href="{{ route('applicant.renewals.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

@php
    $certificate = $application->issuedCertificate;
    $type = $application->certificateType;
    $renewalFee = $type->renewal_fee ?? $type->fee ?? 0;
@endphp

<div class="alert alert-info">
    <i class="bi bi-info-circle"></i>
    আপনি <strong>{{ $type->name_bn }}</strong> সার্টিফিকেটটি নবায়ন করতে যাচ্ছেন। মূল আবেদনের তথ্য ব্যবহার হবে,
    শুধু পেমেন্ট ও অনুমোদন প্রক্রিয়া আবার চালাতে হবে।
</div>

<div class="row g-3">
    <div class="col-md-8">
        {{-- Original Certificate Info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>মূল সার্টিফিকেট</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th width="35%">সার্টিফিকেট নম্বর:</th><td><code>{{ $certificate->certificate_no ?? '-' }}</code></td></tr>
                    <tr><th>ট্র্যাকিং:</th><td><code>{{ $application->tracking_no }}</code></td></tr>
                    <tr><th>ধরন:</th><td><strong>{{ $type->name_bn }}</strong></td></tr>
                    <tr><th>ইস্যু তারিখ:</th><td>{{ bangla_date($certificate->issue_date ?? $application->created_at) }}</td></tr>
                    <tr><th>মেয়াদ শেষ:</th>
                        <td>
                            {{ bangla_date($certificate->expiry_date) }}
                            @if($certificate->expiry_date && $certificate->expiry_date->isPast())
                                <span class="badge bg-danger">মেয়াদ শেষ</span>
                            @else
                                <span class="badge bg-warning text-dark">শীঘ্রই শেষ</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        {{-- Applicant Info --}}
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-header bg-white"><strong>আবেদনকারীর তথ্য</strong></div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th width="35%">নাম:</th><td>{{ $application->applicant_name_bn }}</td></tr>
                    <tr><th>পিতা:</th><td>{{ $application->applicant_father_name ?? '-' }}</td></tr>
                    <tr><th>NID:</th><td>{{ $application->applicant_nid ?? '-' }}</td></tr>
                    <tr><th>মোবাইল:</th><td>{{ $application->applicant_phone }}</td></tr>
                    <tr><th>ওয়ার্ড:</th><td>{{ $application->ward->name_bn ?? '-' }}</td></tr>
                </table>
                <div class="alert alert-light small mt-3 mb-0">
                    <i class="bi bi-info-circle"></i> তথ্য একই থাকলে নতুন করে দিতে হবে না।
                    পরিবর্তন হলে Applicant Profile থেকে আপডেট করুন।
                </div>
            </div>
        </div>

        {{-- Renewal Form --}}
        <form action="{{ route('applicant.applications.renew.store', $application) }}"
              method="POST" id="renewalForm">
            @csrf

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>নবায়নের তথ্য</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">উদ্দেশ্য</label>
                        <textarea name="purpose" rows="3" class="form-control"
                                  placeholder="নবায়নের কারণ (ঐচ্ছিক)">{{ old('purpose') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">পেমেন্ট পদ্ধতি <span class="text-danger">*</span></label>

                        <div class="form-check mb-2">
                            <input type="radio" name="payment_method" value="online"
                                   id="pay_online" class="form-check-input" checked>
                            <label class="form-check-label" for="pay_online">
                                <i class="bi bi-credit-card"></i> অনলাইন (bKash/Nagad)
                            </label>
                        </div>

                        <div class="form-check mb-2">
                            <input type="radio" name="payment_method" value="cash"
                                   id="pay_cash" class="form-check-input">
                            <label class="form-check-label" for="pay_cash">
                                <i class="bi bi-cash"></i> অফিসে নগদ
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg"
                        onclick="return confirm('নিশ্চিত নবায়ন করবেন?')">
                    <i class="bi bi-arrow-clockwise"></i> নবায়ন আবেদন জমা দিন
                </button>
            </div>
        </form>
    </div>

    {{-- Sidebar: Fee Summary --}}
    <div class="col-md-4">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <div class="small opacity-75">নবায়ন ফি</div>
                <h2 class="mb-0">৳ {{ bangla_number(number_format($renewalFee, 0)) }}</h2>
                @if($type->renewal_validity_days || $type->validity_days)
                    <hr class="bg-white">
                    <div class="small">
                        নতুন মেয়াদ: {{ bangla_number($type->renewal_validity_days ?? $type->validity_days) }} দিন
                    </div>
                @endif
            </div>
        </div>

        <div class="card border-0 shadow-sm mt-3">
            <div class="card-header bg-white"><strong>নবায়ন কীভাবে কাজ করে</strong></div>
            <div class="card-body">
                <ol class="small ps-3 mb-0">
                    <li>নবায়ন আবেদন জমা হবে</li>
                    <li>ফি পরিশোধ করুন</li>
                    <li>ওয়ার্ড সদস্য দ্রুত যাচাই করবেন</li>
                    <li>চেয়ারম্যান অনুমোদন দেবেন</li>
                    <li>নতুন সার্টিফিকেট ইস্যু হবে</li>
                    <li>নতুন QR code সহ প্রিন্ট হবে</li>
                </ol>
            </div>
        </div>

        @if($application->renewal_count > 0)
        <div class="alert alert-warning mt-3 small">
            <i class="bi bi-exclamation-triangle"></i>
            এটি {{ bangla_number($application->renewal_count) }} তম নবায়ন।
        </div>
        @endif
    </div>
</div>
@endsection