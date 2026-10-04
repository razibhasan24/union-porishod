@extends('layouts.guest')

@section('title', 'লগইন')

@section('content')
<div class="text-center mb-4">
    @if(current_union()?->logo)
        <img src="{{ asset('storage/' . current_union()->logo) }}"
             class="mb-3 rounded-circle border border-3 border-primary p-1"
             width="75" height="75" style="object-fit: cover;" alt="Logo">
    @else
        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
             style="width: 75px; height: 75px;">
            <i class="bi bi-person-circle text-primary" style="font-size: 45px;"></i>
        </div>
    @endif
    <h3 class="fw-bold mb-1">স্বাগতম!</h3>
    <p class="text-muted">আপনার অ্যাকাউন্টে লগইন করুন</p>
</div>

@if (session('status'))
    <div class="alert alert-success mb-3">
        <i class="bi bi-check-circle"></i> {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mb-3">
        <i class="bi bi-exclamation-circle"></i>
        @foreach ($errors->all() as $error)
            {{ $error }}<br>
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf

    {{-- Email or Phone --}}
    <div class="mb-3">
        <label for="email" class="form-label">
            <i class="bi bi-envelope"></i> ইমেইল / মোবাইল নম্বর
        </label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-person"></i>
            </span>
            <input type="text"
                   id="email"
                   name="email"
                   value="{{ old('email') }}"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="example@email.com বা 01XXXXXXXXX"
                   required
                   autofocus
                   autocomplete="username">
        </div>
        @error('email')
            <small class="text-danger">
                <i class="bi bi-exclamation-circle"></i> {{ $message }}
            </small>
        @enderror
    </div>

    {{-- Password --}}
    <div class="mb-3">
        <label for="password" class="form-label">
            <i class="bi bi-lock"></i> পাসওয়ার্ড
        </label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="bi bi-key"></i>
            </span>
            <input type="password"
                   id="password"
                   name="password"
                   class="form-control @error('password') is-invalid @enderror"
                   placeholder="পাসওয়ার্ড দিন"
                   required
                   autocomplete="current-password">
            <button type="button"
                    class="btn btn-outline-secondary"
                    onclick="togglePassword()"
                    id="toggleBtn"
                    style="border-radius: 0 10px 10px 0;">
                <i class="bi bi-eye" id="toggleIcon"></i>
            </button>
        </div>
        @error('password')
            <small class="text-danger">
                <i class="bi bi-exclamation-circle"></i> {{ $message }}
            </small>
        @enderror
    </div>

    {{-- Remember & Forgot --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
            <input type="checkbox"
                   name="remember"
                   id="remember"
                   class="form-check-input">
            <label class="form-check-label small" for="remember">
                মনে রাখুন
            </label>
        </div>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}"
               class="small text-decoration-none fw-bold">
                পাসওয়ার্ড ভুলে গেছেন?
            </a>
        @endif
    </div>

    {{-- Submit --}}
    <button type="submit" class="btn btn-login w-100">
        <i class="bi bi-box-arrow-in-right"></i> লগইন করুন
    </button>
</form>

@if (Route::has('register'))
    <div class="divider">
        <span>অথবা</span>
    </div>

    <div class="text-center">
        <p class="text-muted small mb-2">নতুন ব্যবহারকারী?</p>
        <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">
            <i class="bi bi-person-plus"></i> নতুন অ্যাকাউন্ট খুলুন
        </a>
    </div>
@endif

{{-- Quick Access (Demo Only - Remove in production) --}}
@if(config('app.debug'))
<div class="mt-4 p-3 bg-light rounded" style="font-size: 12px;">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <strong class="text-muted">🔐 ডেমো অ্যাকাউন্ট</strong>
        <button type="button" class="btn btn-sm btn-link p-0 text-decoration-none"
                data-bs-toggle="collapse" data-bs-target="#demoAccounts">
            দেখান/লুকান
        </button>
    </div>
    <div class="collapse" id="demoAccounts">
        <table class="table table-sm mb-0">
            <tr>
                <td><strong>Super Admin</strong></td>
                <td><code>superadmin@demo-up.gov.bd</code></td>
                <td><code>password</code></td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary py-0 px-2"
                            onclick="fillDemo('superadmin@demo-up.gov.bd')">
                        Fill
                    </button>
                </td>
            </tr>
            <tr>
                <td><strong>Chairman</strong></td>
                <td><code>chairman@demo-up.gov.bd</code></td>
                <td><code>password</code></td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary py-0 px-2"
                            onclick="fillDemo('chairman@demo-up.gov.bd')">
                        Fill
                    </button>
                </td>
            </tr>
            <tr>
                <td><strong>Ward Member</strong></td>
                <td><code>ward1@demo-up.gov.bd</code></td>
                <td><code>password</code></td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary py-0 px-2"
                            onclick="fillDemo('ward1@demo-up.gov.bd')">
                        Fill
                    </button>
                </td>
            </tr>
            <tr>
                <td><strong>Applicant</strong></td>
                <td><code>applicant@demo-up.gov.bd</code></td>
                <td><code>password</code></td>
                <td>
                    <button type="button" class="btn btn-sm btn-primary py-0 px-2"
                            onclick="fillDemo('applicant@demo-up.gov.bd')">
                        Fill
                    </button>
                </td>
            </tr>
        </table>
    </div>
</div>
@endif

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleIcon.classList.remove('bi-eye');
        toggleIcon.classList.add('bi-eye-slash');
    } else {
        passwordInput.type = 'password';
        toggleIcon.classList.remove('bi-eye-slash');
        toggleIcon.classList.add('bi-eye');
    }
}

function fillDemo(email) {
    document.getElementById('email').value = email;
    document.getElementById('password').value = 'password';
    document.getElementById('password').focus();
}
</script>
@endsection
