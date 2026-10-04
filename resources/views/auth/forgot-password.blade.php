@extends('layouts.guest')

@section('title', 'পাসওয়ার্ড রিসেট')

@section('content')
<div class="text-center mb-4">
    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
         style="width: 75px; height: 75px;">
        <i class="bi bi-key text-warning" style="font-size: 40px;"></i>
    </div>
    <h3 class="fw-bold mb-1">পাসওয়ার্ড ভুলে গেছেন?</h3>
    <p class="text-muted">আপনার ইমেইল দিন, রিসেট লিংক পাঠাব</p>
</div>

@if (session('status'))
    <div class="alert alert-success mb-3">
        <i class="bi bi-check-circle"></i> {{ session('status') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger mb-3">
        @foreach ($errors->all() as $error)
            <i class="bi bi-exclamation-circle"></i> {{ $error }}
        @endforeach
    </div>
@endif

<form method="POST" action="{{ route('password.email') }}">
    @csrf

    <div class="mb-3">
        <label for="email" class="form-label">
            <i class="bi bi-envelope"></i> ইমেইল
        </label>
        <input type="email"
               id="email"
               name="email"
               value="{{ old('email') }}"
               class="form-control"
               placeholder="example@email.com"
               required
               autofocus>
    </div>

    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">
        <i class="bi bi-send"></i> রিসেট লিংক পাঠান
    </button>
</form>

<div class="text-center mt-3">
    <a href="{{ route('login') }}" class="text-decoration-none small">
        <i class="bi bi-arrow-left"></i> লগইনে ফিরে যান
    </a>
</div>
@endsection
