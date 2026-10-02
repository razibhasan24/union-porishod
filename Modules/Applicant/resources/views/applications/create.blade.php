@extends('applicant::layouts.app')

@section('title', 'নতুন আবেদন')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4><i class="bi bi-plus-circle"></i> নতুন আবেদন</h4>
    <a href="{{ route('applicant.applications.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> ফিরে যান
    </a>
</div>

<form action="{{ route('applicant.applications.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row g-3">
        <div class="col-md-8">
            {{-- Certificate Type --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>সার্টিফিকেটের ধরন</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach($types as $type)
                        <div class="col-md-4">
                            <label class="cert-type-card border rounded p-3 d-block text-center"
                                   style="cursor: pointer; height: 100%;">
                                <input type="radio" name="certificate_type_id" value="{{ $type->id }}"
                                       class="d-none" required
                                       data-fee="{{ $type->fee }}"
                                       data-warish="{{ $type->is_warish ? 1 : 0 }}"
                                       {{ old('certificate_type_id') == $type->id ? 'checked' : '' }}>
                                <i class="bi bi-{{ $type->icon ?? 'file-text' }} fs-2"
                                   style="color: {{ $type->color ?? '#3b82f6' }};"></i>
                                <div class="mt-2 fw-bold">{{ $type->name_bn }}</div>
                                <div class="text-muted small">৳ {{ bangla_number(number_format($type->fee, 0)) }}</div>
                            </label>
                        </div>
                        @endforeach
                    </div>
                    @error('certificate_type_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Personal Info --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>ব্যক্তিগত তথ্য</strong></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">পিতার নাম</label>
                            <input type="text" name="father_name" value="{{ old('father_name') }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">মাতার নাম</label>
                            <input type="text" name="mother_name" value="{{ old('mother_name') }}"
                                   class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">ওয়ার্ড <span class="text-danger">*</span></label>
                            <select name="ward_id" class="form-select" required>
                                <option value="">-- নির্বাচন --</option>
                                @foreach($wards as $w)
                                    <option value="{{ $w->id }}"
                                        {{ old('ward_id', auth()->user()->ward_id) == $w->id ? 'selected' : '' }}>
                                        {{ $w->name_bn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">গ্রাম</label>
                            <select name="village_id" class="form-select">
                                <option value="">-- নির্বাচন --</option>
                                @foreach($villages as $v)
                                    <option value="{{ $v->id }}"
                                        {{ old('village_id', auth()->user()->village_id) == $v->id ? 'selected' : '' }}>
                                        {{ $v->name_bn }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label">ঠিকানা</label>
                            <input type="text" name="address" value="{{ old('address') }}"
                                   class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">উদ্দেশ্য <span class="text-danger">*</span></label>
                            <textarea name="purpose" rows="3" class="form-control" required
                                      placeholder="কেন এই সার্টিফিকেট দরকার...">{{ old('purpose') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Documents --}}
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>ডকুমেন্ট সংযুক্তি</strong></div>
                <div class="card-body">
                    <input type="file" name="documents[]" class="form-control mb-2" multiple
                           accept="image/*,application/pdf">
                    <small class="text-muted">
                        NID কপি, ছবি ইত্যাদি (সর্বোচ্চ ৫MB প্রতিটি)
                    </small>
                </div>
            </div>

            {{-- Warish Section --}}
            <div class="card border-0 shadow-sm mb-3 d-none" id="warishSection">
                <div class="card-header bg-warning text-dark">
                    <strong>ওয়ারিশ তথ্য</strong>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">মৃত ব্যক্তির নাম</label>
                            <input type="text" name="deceased_info[name]" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">মৃত্যুর তারিখ</label>
                            <input type="date" name="deceased_info[death_date]" class="form-control">
                        </div>
                    </div>

                    <label class="form-label"><strong>উত্তরাধিকারীবৃন্দ:</strong></label>
                    <div id="heirsContainer">
                        <div class="row g-2 mb-2 heir-row">
                            <div class="col-md-4">
                                <input type="text" name="heirs[0][name]" class="form-control" placeholder="নাম">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="heirs[0][relation]" class="form-control" placeholder="সম্পর্ক">
                            </div>
                            <div class="col-md-2">
                                <input type="number" name="heirs[0][age]" class="form-control" placeholder="বয়স">
                            </div>
                            <div class="col-md-3">
                                <input type="text" name="heirs[0][nid]" class="form-control" placeholder="NID">
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary" id="addHeirBtn">
                        <i class="bi bi-plus-circle"></i> আরও যোগ করুন
                    </button>
                </div>
            </div>
        </div>

        {{-- Sidebar: Payment --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-header bg-white"><strong>পেমেন্ট পদ্ধতি</strong></div>
                <div class="card-body">
                    <div class="form-check mb-2">
                        <input type="radio" name="payment_method" value="online" id="pay_online"
                               class="form-check-input" required checked>
                        <label class="form-check-label" for="pay_online">
                            <i class="bi bi-credit-card"></i> অনলাইন (bKash/Nagad)
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input type="radio" name="payment_method" value="cash" id="pay_cash"
                               class="form-check-input">
                        <label class="form-check-label" for="pay_cash">
                            <i class="bi bi-cash"></i> অফিসে নগদ
                        </label>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between">
                        <span>ফি:</span>
                        <strong id="feeDisplay">৳ ০</strong>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-send"></i> আবেদন জমা দিন
                </button>
                <a href="{{ route('applicant.applications.index') }}" class="btn btn-secondary">বাতিল</a>
            </div>
        </div>
    </div>
</form>
@endsection

@push('styles')
<style>
    .cert-type-card { transition: all 0.2s; }
    .cert-type-card:hover { border-color: #0d6efd !important; background: #f8f9fa; }
    .cert-type-card.selected { border-color: #0d6efd !important; background: #e7f1ff; border-width: 2px !important; }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.cert-type-card');
    const feeDisplay = document.getElementById('feeDisplay');
    const warishSection = document.getElementById('warishSection');

    cards.forEach(card => {
        card.addEventListener('click', function() {
            cards.forEach(c => c.classList.remove('selected'));
            this.classList.add('selected');

            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;

            const fee = radio.dataset.fee || 0;
            feeDisplay.textContent = '৳ ' + Number(fee).toLocaleString('bn-BD');

            if (radio.dataset.warish === '1') {
                warishSection.classList.remove('d-none');
            } else {
                warishSection.classList.add('d-none');
            }
        });
    });

    // Add heir button
    let heirIndex = 1;
    document.getElementById('addHeirBtn')?.addEventListener('click', function() {
        const container = document.getElementById('heirsContainer');
        const newRow = document.createElement('div');
        newRow.className = 'row g-2 mb-2 heir-row';
        newRow.innerHTML = `
            <div class="col-md-4"><input type="text" name="heirs[${heirIndex}][name]" class="form-control" placeholder="নাম"></div>
            <div class="col-md-3"><input type="text" name="heirs[${heirIndex}][relation]" class="form-control" placeholder="সম্পর্ক"></div>
            <div class="col-md-2"><input type="number" name="heirs[${heirIndex}][age]" class="form-control" placeholder="বয়স"></div>
            <div class="col-md-3"><input type="text" name="heirs[${heirIndex}][nid]" class="form-control" placeholder="NID"></div>
        `;
        container.appendChild(newRow);
        heirIndex++;
    });
});
</script>
@endpush