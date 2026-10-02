@extends('core::layouts.app')

@section('title', 'নতুন সার্টিফিকেট ধরন')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-plus-circle"></i> নতুন সার্টিফিকেট ধরন</h4>
    <a href="{{ route('certificate.types.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<form action="{{ route('certificate.types.store') }}" method="POST">
    @csrf

    <div class="row g-3">
        <div class="col-md-8">
            {{-- Basic Info --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>মূল তথ্য</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">ইউনিয়ন <span class="text-danger">*</span></label>
                            <select name="union_id" class="form-select @error('union_id') is-invalid @enderror" required>
                                <option value="">-- নির্বাচন --</option>
                                @foreach($unions as $u)
                                    <option value="{{ $u->id }}" {{ old('union_id') == $u->id ? 'selected' : '' }}>
                                        {{ $u->name_bn }}
                                    </option>
                                @endforeach
                            </select>
                            @error('union_id') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">কোড</label>
                            <input type="text" name="code" value="{{ old('code') }}"
                                   class="form-control" placeholder="যেমন: CIT, WAR">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">নাম (বাংলা) <span class="text-danger">*</span></label>
                            <input type="text" name="name_bn" value="{{ old('name_bn') }}"
                                   class="form-control @error('name_bn') is-invalid @enderror" required>
                            @error('name_bn') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">নাম (ইংরেজি) <span class="text-danger">*</span></label>
                            <input type="text" name="name_en" value="{{ old('name_en') }}"
                                   class="form-control @error('name_en') is-invalid @enderror" required>
                            @error('name_en') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">বিবরণ (বাংলা)</label>
                            <textarea name="description_bn" class="form-control" rows="2">{{ old('description_bn') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Fee & Validity --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>ফি ও বৈধতা</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">ফি (৳) <span class="text-danger">*</span></label>
                            <input type="number" name="fee" value="{{ old('fee', 0) }}"
                                   class="form-control" step="0.01" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">নবায়ন ফি (৳)</label>
                            <input type="number" name="renewal_fee" value="{{ old('renewal_fee') }}"
                                   class="form-control" step="0.01">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">ডুপ্লিকেট ফি (৳)</label>
                            <input type="number" name="duplicate_fee" value="{{ old('duplicate_fee') }}"
                                   class="form-control" step="0.01">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">বৈধতার সময় (দিন) <span class="text-danger">*</span></label>
                            <input type="number" name="validity_days" value="{{ old('validity_days', 90) }}"
                                   class="form-control" required>
                            <small class="text-muted">৯০ দিন = ৩ মাস</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">প্রিন্ট কত দিন পর? <span class="text-danger">*</span></label>
                            <input type="number" name="print_after_days" value="{{ old('print_after_days', 0) }}"
                                   class="form-control" required>
                            <small class="text-muted">০ = সাথে সাথে, ৩০ = ৩০ দিন পর</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Serial Format --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>সিরিয়াল ফরম্যাট</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">সিরিয়াল প্রিফিক্স</label>
                            <input type="text" name="serial_prefix" value="{{ old('serial_prefix', 'UP/CERT') }}"
                                   class="form-control">
                            <small class="text-muted">যেমন: UP/CIT → UP/CIT/2025/0001</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">প্যাডিং</label>
                            <input type="number" name="serial_padding" value="{{ old('serial_padding', 4) }}"
                                   class="form-control" min="1" max="10">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Special Options --}}
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white"><strong>বিশেষ অপশন</strong></div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input type="hidden" name="is_warish" value="0">
                        <input type="checkbox" name="is_warish" value="1" class="form-check-input"
                               id="is_warish" {{ old('is_warish') ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_warish">
                            <strong>ওয়ারিশ সনদ</strong> (উত্তরাধিকারী তথ্য লাগবে)
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="hidden" name="requires_heirs" value="0">
                        <input type="checkbox" name="requires_heirs" value="1" class="form-check-input"
                               id="requires_heirs" {{ old('requires_heirs') ? 'checked' : '' }}>
                        <label class="form-check-label" for="requires_heirs">
                            উত্তরাধিকারী তথ্য আবশ্যক
                        </label>
                    </div>
                    <div class="form-check mb-2">
                        <input type="hidden" name="requires_property" value="0">
                        <input type="checkbox" name="requires_property" value="1" class="form-check-input"
                               id="requires_property" {{ old('requires_property') ? 'checked' : '' }}>
                        <label class="form-check-label" for="requires_property">
                            সম্পত্তির তথ্য আবশ্যক
                        </label>
                    </div>
                    <hr>
                    <div class="form-check mb-2">
                        <input type="hidden" name="needs_ward_verification" value="0">
                        <input type="checkbox" name="needs_ward_verification" value="1" class="form-check-input"
                               id="needs_ward_verification" {{ old('needs_ward_verification', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="needs_ward_verification">
                            ওয়ার্ড সদস্যের যাচাই আবশ্যক
                        </label>
                    </div>
                    <div class="form-check">
                        <input type="hidden" name="needs_chairman_approval" value="0">
                        <input type="checkbox" name="needs_chairman_approval" value="1" class="form-check-input"
                               id="needs_chairman_approval" {{ old('needs_chairman_approval', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="needs_chairman_approval">
                            চেয়ারম্যানের অনুমোদন আবশ্যক
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>UI সেটিংস</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">আইকন</label>
                        <input type="text" name="icon" value="{{ old('icon', 'file-text') }}"
                               class="form-control" placeholder="bi bi-file-text">
                        <small class="text-muted">
                            Bootstrap icon নাম:
                            <a href="https://icons.getbootstrap.com" target="_blank">দেখুন</a>
                        </small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">রঙ</label>
                        <input type="color" name="color" value="{{ old('color', '#3b82f6') }}"
                               class="form-control form-control-color">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ক্রম</label>
                        <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}"
                               class="form-control">
                    </div>
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input"
                               id="is_active" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">সক্রিয়</label>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> সংরক্ষণ করুন
                </button>
                <a href="{{ route('certificate.types.index') }}" class="btn btn-secondary">
                    বাতিল
                </a>
            </div>
        </div>
    </div>
</form>
@endsection