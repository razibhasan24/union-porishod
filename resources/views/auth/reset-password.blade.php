@extends('layouts.guest')

@section('title', 'নতুন পাসওয়ার্ড')

@section('content')
<div class="text-center mb-4">
    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
         style="width: 75px; height: 75px;">
        <i class="bi bi-shield-lock text-primary" style="font-size: 40px;"></i>
    </div>
    <h3 class="fw-bold mb-1">নতুন পাসওয়ার্ড সেট করুন</h3>
    <p class="text-muted">নিরাপদ পাসওয়ার্ড দিন</p>
</div>

@if ($errors->any())
    <div class="alert alert-danger mb-3">
        @foreach ($errors->all() as $error)
            <i class="bi bi-exclamation-circle"></i> {{ $error }}<br>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('password.store') }}">
    @csrf
    <input type="hidden" name="token" value="{{ $request->route('token') }}">

    <div class="mb-3">
        <label for="email" class="form-label">
            <i class="bi bi-envelope"></i> ইমেইল
        </label>
        <input type="email"
               id="email"
               name="email"
               value="{{ old('email', $request->email) }}"
               class="form-control"
               required
               readonly>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">
            <i class="bi bi-lock"></i> নতুন পাসওয়ার্ড
        </label>
        <input type="password"
               id="password"
               name="password"
               class="form-control"
               placeholder="কমপক্ষে ৮ অক্ষর"
               required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">
            <i class="bi bi-lock-fill"></i> নিশ্চিত করুন
        </label>
        <input type="password"
               id="password_confirmation"
               name="password_confirmation"
               class="form-control"
               placeholder="আবার লিখুন"
               required>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
        <i class="bi bi-check-circle"></i> পাসওয়ার্ড রিসেট করুন
    </button>
</form>
@endsection
