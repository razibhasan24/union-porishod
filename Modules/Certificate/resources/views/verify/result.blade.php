<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>যাচাই ফলাফল</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 20px 0;
            font-family: 'SolaimanLipi', 'Segoe UI', sans-serif;
        }
        .result-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="result-card">
                    @if($valid && isset($certificate))
                        {{-- Valid Certificate --}}
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 100px; height: 100px;">
                                <i class="bi bi-patch-check-fill text-success" style="font-size: 55px;"></i>
                            </div>
                            <h2 class="text-success">✓ সার্টিফিকেটটি বৈধ</h2>
                            <p class="text-muted">{{ $message }}</p>
                        </div>

                        <div class="alert alert-success">
                            <strong>সার্টিফিকেট নম্বর:</strong>
                            <code>{{ $certificate->certificate_no }}</code>
                        </div>

                        <table class="table table-bordered">
                            <tr>
                                <th width="40%">সার্টিফিকেটের ধরন</th>
                                <td><strong>{{ $application->certificateType->name_bn ?? '-' }}</strong></td>
                            </tr>
                            <tr>
                                <th>প্রাপকের নাম</th>
                                <td>{{ $application->applicant_name_bn }}</td>
                            </tr>
                            <tr>
                                <th>পিতার নাম</th>
                                <td>{{ $application->applicant_father_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>ওয়ার্ড / গ্রাম</th>
                                <td>
                                    {{ $application->ward->name_bn ?? '-' }}
                                    @if($application->village), {{ $application->village->name_bn }}@endif
                                </td>
                            </tr>
                            <tr>
                                <th>ইউনিয়ন</th>
                                <td>{{ $application->union->name_bn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>ইস্যু তারিখ</th>
                                <td>{{ bangla_date($certificate->issue_date) }}</td>
                            </tr>
                            @if($certificate->expiry_date)
                            <tr>
                                <th>মেয়াদ শেষ</th>
                                <td>
                                    {{ bangla_date($certificate->expiry_date) }}
                                    @if(!$isExpired)
                                        <span class="badge bg-success ms-2">বৈধ</span>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <th>ইস্যুকারী</th>
                                <td>{{ $certificate->issued_by_name ?? '-' }} ({{ $certificate->issued_by_designation ?? '-' }})</td>
                            </tr>
                        </table>

                    @else
                        {{-- Invalid Certificate --}}
                        <div class="text-center mb-4">
                            <div class="rounded-circle bg-danger bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3"
                                 style="width: 100px; height: 100px;">
                                <i class="bi bi-x-octagon-fill text-danger" style="font-size: 55px;"></i>
                            </div>
                            <h2 class="text-danger">সার্টিফিকেটটি বৈধ নয়</h2>
                            <p class="text-muted">{{ $message }}</p>
                        </div>

                        <div class="alert alert-danger">
                            <strong>কোড:</strong> <code>{{ $code }}</code>
                        </div>

                        @if(isset($certificate) && $isCancelled)
                            <div class="alert alert-warning">
                                <strong>বাতিলের কারণ:</strong> {{ $certificate->cancelled_reason ?? 'কারণ লিপিবদ্ধ নেই' }}
                                @if($certificate->cancelled_at)
                                    <br><small>বাতিলের তারিখ: {{ bangla_date($certificate->cancelled_at) }}</small>
                                @endif
                            </div>
                        @endif
                    @endif

                    <div class="text-center mt-4">
                        <a href="{{ route('verify.form') }}" class="btn btn-primary">
                            <i class="bi bi-arrow-left"></i> অন্য সার্টিফিকেট যাচাই করুন
                        </a>
                        <a href="{{ url('/') }}" class="btn btn-secondary">
                            <i class="bi bi-house"></i> হোম
                        </a>
                    </div>

                    <hr class="my-4">
                    <p class="text-center text-muted small mb-0">
                        এটি {{ current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ' }}-এর অফিসিয়াল ভেরিফিকেশন পোর্টাল
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>