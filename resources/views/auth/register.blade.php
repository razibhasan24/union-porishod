@extends('layouts.guest')

@section('title', 'নিবন্ধন')

@section('content')
<div class="text-center mb-4">
    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
         style="width: 75px; height: 75px;">
        <i class="bi bi-person-plus text-success" style="font-size: 40px;"></i>
    </div>
    <h3 class="fw-bold mb-1">নতুন অ্যাকাউন্ট</h3>
    <p class="text-muted">সার্টিফিকেট আবেদনের জন্য নিবন্ধন করুন</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger mb-3">
        <i class="bi bi-exclamation-circle"></i>
        <strong>কিছু সমস্যা হয়েছে:</strong>
        <ul class="mb-0 mt-2 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('register') }}">
    @csrf

    {{-- Name --}}
    <div class="mb-3">
        <label for="name" class="form-label">
            <i class="bi bi-person"></i> পূর্ণ নাম <span class="text-danger">*</span>
        </label>
        <input type="text"
               id="name"
               name="name"
               value="{{ old('name') }}"
               class="form-control @error('name') is-invalid @enderror"
               placeholder="আপনার পূর্ণ নাম লিখুন"
               required
               autofocus>
    </div>

    {{-- Phone --}}
    <div class="mb-3">
        <label for="phone" class="form-label">
            <i class="bi bi-phone"></i> মোবাইল নম্বর <span class="text-danger">*</span>
        </label>
        <div class="input-group">
            <span class="input-group-text">+88</span>
            <input type="text"
                   id="phone"
                   name="phone"
                   value="{{ old('phone') }}"
                   class="form-control @error('phone') is-invalid @enderror"
                   placeholder="01XXXXXXXXX"
                   required>
        </div>
        <small class="text-muted">এই নম্বরেই SMS-এ সব আপডেট পাবেন</small>
    </div>

    {{-- Email --}}
    <div class="mb-3">
        <label for="email" class="form-label">
            <i class="bi bi-envelope"></i> ইমেইল (ঐচ্ছিক)
        </label>
        <input type="email"
               id="email"
               name="email"
               value="{{ old('email') }}"
               class="form-control @error('email') is-invalid @enderror"
               placeholder="example@email.com">
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">
            <i class="bi bi-lock"></i> পাসওয়ার্ড <span class="text-danger">*</span>
        </label>
        <input type="password"
               id="password"
               name="password"
               class="form-control @error('password') is-invalid @enderror"
               placeholder="কমপক্ষে ৮ অক্ষর"
               required>
        <small class="text-muted">কমপক্ষে ৮ অক্ষর, সংখ্যা ও বর্ণ মিলিয়ে</small>
    </div>

    {{-- Password Confirmation --}}
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">
            <i class="bi bi-lock-fill"></i> পাসওয়ার্ড নিশ্চিত করুন <span class="text-danger">*</span>
        </label>
        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               class="form-control"
               placeholder="আবার লিখুন"
               required>
    </div>

    {{-- Terms --}}
    <div class="form-check mb-3">
        <input type="checkbox" class="form-check-input" id="terms" required>
        <label class="form-check-label small" for="terms">
            আমি <a href="#" class="text-decoration-none">শর্তাবলী</a> ও
            <a href="#" class="text-decoration-none">গোপনীয়তা নীতি</a> মেনে নিচ্ছি
        </label>
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn btn-success w-100 py-2 fw-bold">
        <i class="bi bi-check-circle"></i> নিবন্ধন সম্পন্ন করুন
    </button>
</form>

<div class="divider">
    <span>অথবা</span>
</div>

<div class="text-center">
    <p class="text-muted small mb-2">ইতিমধ্যে অ্যাকাউন্ট আছে?</p>
    <a href="{{ route('login') }}" class="btn btn-outline-primary w-100">
        <i class="bi bi-box-arrow-in-right"></i> লগইন করুন
    </a>
</div>
@endsection
