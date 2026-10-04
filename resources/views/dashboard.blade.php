<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ড্যাশবোর্ড — {{ current_union()?->name_bn ?? config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            font-family: 'SolaimanLipi', 'Segoe UI', Tahoma, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f4f6fa 0%, #e8edf5 100%);
            min-height: 100vh;
        }

        .navbar-main {
            background: linear-gradient(135deg, #0d6efd 0%, #0a4d8c 100%);
            box-shadow: 0 4px 15px rgba(13, 110, 253, 0.15);
        }

        .welcome-hero {
            background: linear-gradient(135deg, #0d6efd 0%, #0a4d8c 100%);
            color: white;
            border-radius: 24px;
            padding: 40px;
            position: relative;
            overflow: hidden;
            margin-bottom: 30px;
            box-shadow: 0 20px 50px rgba(13, 110, 253, 0.25);
        }

        .welcome-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulse 6s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .welcome-hero h1 {
            font-size: 2.2rem;
            font-weight: 700;
            position: relative;
            z-index: 1;
            margin-bottom: 12px;
        }

        .welcome-hero p {
            font-size: 1.05rem;
            position: relative;
            z-index: 1;
            opacity: 0.95;
            margin-bottom: 0;
        }

        .user-avatar-big {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 4px solid rgba(255, 255, 255, 0.3);
            object-fit: cover;
            position: relative;
            z-index: 1;
        }

        .info-card {
            background: white;
            border-radius: 18px;
            padding: 25px;
            border: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            transition: all 0.3s;
            height: 100%;
        }

        .info-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .info-card .card-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .info-card h6 {
            font-weight: 700;
            color: #374151;
            margin-bottom: 8px;
        }

        .info-card p {
            color: #6b7280;
            font-size: 0.9rem;
            margin-bottom: 0;
        }

        .action-button {
            display: block;
            background: white;
            border-radius: 16px;
            padding: 20px;
            text-decoration: none;
            color: inherit;
            border: 2px solid #e5e7eb;
            transition: all 0.2s;
            height: 100%;
        }

        .action-button:hover {
            border-color: #0d6efd;
            background: #f0f7ff;
            color: #0d6efd;
            transform: translateY(-3px);
        }

        .action-button i {
            font-size: 32px;
            display: block;
            margin-bottom: 10px;
        }

        .role-badge {
            display: inline-block;
            padding: 8px 18px;
            border-radius: 25px;
            font-size: 0.85rem;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .footer-main {
            background: white;
            border-top: 1px solid #e5e7eb;
            padding: 25px 0;
            margin-top: 50px;
            text-align: center;
            color: #6b7280;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    {{-- ================= NAVBAR ================= --}}
    <nav class="navbar navbar-expand-lg navbar-dark navbar-main">
        <div class="container">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('dashboard') }}">
                @if (current_union()?->logo)
                    <img src="{{ asset('storage/' . current_union()->logo) }}" width="38" height="38"
                        class="me-2 rounded bg-white p-1" alt="Logo">
                @else
                    <i class="bi bi-building me-2" style="font-size: 28px;"></i>
                @endif
                {{ current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ' }}
            </a>

            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white" href="#"
                        data-bs-toggle="dropdown">
                        <img src="{{ auth()->user()->photo_url ?? asset('images/default-avatar.png') }}" width="36"
                            height="36" class="rounded-circle me-2 border border-2 border-light" alt="User">
                        <span>{{ auth()->user()->display_name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> লগআউট
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    {{-- ================= MAIN CONTENT ================= --}}
    <div class="container py-5">

        @php
            $user = auth()->user();
            $userTypeLabel = \Modules\Core\Enums\UserType::tryFrom($user->user_type)?->labelBn() ?? $user->user_type;
        @endphp

        {{-- Welcome Hero --}}
        <div class="welcome-hero">
            <div class="row align-items-center position-relative" style="z-index: 1;">
                <div class="col-md-8">
                    <h1>
                        <i class="bi bi-emoji-smile"></i>
                        স্বাগতম, {{ $user->display_name }}!
                    </h1>
                    <p class="mb-3">
                        আজ {{ bangla_date(now()) }} — আপনার ইউনিয়ন পরিষদের অনলাইন সেবা কেন্দ্রে আপনাকে স্বাগতম।
                    </p>
                    <span class="role-badge">
                        <i class="bi bi-person-badge"></i> {{ $userTypeLabel }}
                    </span>
                </div>
                <div class="col-md-4 text-center d-none d-md-block">
                    <img src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}" class="user-avatar-big"
                        alt="User">
                </div>
            </div>
        </div>

        {{-- Alerts --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Account Info --}}
        <h5 class="mb-3"><i class="bi bi-info-circle text-primary"></i> আপনার অ্যাকাউন্ট তথ্য</h5>
        <div class="row g-3 mb-4">
            <div class="col-md-3 col-6">
                <div class="info-card">
                    <div class="card-icon bg-primary bg-opacity-10 text-primary">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <h6>নাম</h6>
                    <p>{{ $user->display_name }}</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="info-card">
                    <div class="card-icon bg-success bg-opacity-10 text-success">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <h6>মোবাইল</h6>
                    <p>{{ $user->phone ?? 'নেই' }}</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="info-card">
                    <div class="card-icon bg-warning bg-opacity-10 text-warning">
                        <i class="bi bi-shield-check"></i>
                    </div>
                    <h6>ইউজার টাইপ</h6>
                    <p>{{ $userTypeLabel }}</p>
                </div>
            </div>

            <div class="col-md-3 col-6">
                <div class="info-card">
                    <div class="card-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-building"></i>
                    </div>
                    <h6>ইউনিয়ন</h6>
                    <p>{{ current_union()?->name_bn ?? 'নেই' }}</p>
                </div>
            </div>
        </div>

        {{-- Action Buttons (Role Based) --}}
        <h5 class="mb-3"><i class="bi bi-lightning-charge text-warning"></i> দ্রুত কাজ</h5>
        <div class="row g-3">

            @if ($user->isApplicant())
                {{-- Applicant Actions --}}
                <div class="col-md-3 col-6">
                    <a href="{{ route('applicant.dashboard') }}" class="action-button text-center">
                        <i class="bi bi-speedometer2 text-primary"></i>
                        <h6 class="mb-0">আমার ড্যাশবোর্ড</h6>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('applicant.applications.create') }}" class="action-button text-center">
                        <i class="bi bi-plus-circle text-success"></i>
                        <h6 class="mb-0">নতুন আবেদন</h6>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('applicant.applications.index') }}" class="action-button text-center">
                        <i class="bi bi-list-check text-warning"></i>
                        <h6 class="mb-0">আমার আবেদন</h6>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('verify.form') }}" class="action-button text-center">
                        <i class="bi bi-shield-check text-info"></i>
                        <h6 class="mb-0">যাচাই করুন</h6>
                    </a>
                </div>
            @else
                {{-- Admin Actions --}}
                <div class="col-md-3 col-6">
                    <a href="{{ route('core.dashboard') }}" class="action-button text-center">
                        <i class="bi bi-speedometer2 text-primary"></i>
                        <h6 class="mb-0">অ্যাডমিন প্যানেল</h6>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('certificate.applications.index') }}" class="action-button text-center">
                        <i class="bi bi-file-earmark-text text-success"></i>
                        <h6 class="mb-0">আবেদন তালিকা</h6>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('report.dashboard') }}" class="action-button text-center">
                        <i class="bi bi-graph-up text-warning"></i>
                        <h6 class="mb-0">রিপোর্ট</h6>
                    </a>
                </div>
                <div class="col-md-3 col-6">
                    <a href="{{ route('verify.form') }}" class="action-button text-center">
                        <i class="bi bi-shield-check text-info"></i>
                        <h6 class="mb-0">যাচাই</h6>
                    </a>
                </div>
            @endif
        </div>

        {{-- Info Banner --}}
        <div class="alert alert-info border-0 mt-4 shadow-sm" style="border-radius: 15px;">
            <div class="d-flex align-items-center">
                <i class="bi bi-info-circle-fill fs-3 me-3"></i>
                <div>
                    <strong>আপনার জন্য উপযুক্ত ড্যাশবোর্ডে redirect হবে</strong>
                    <p class="mb-0 small">
                        উপরের button থেকে সরাসরি প্যানেলে যেতে পারেন।
                    </p>
                </div>
            </div>
        </div>

    </div>

    {{-- ================= FOOTER ================= --}}
    <footer class="footer-main">
        <div class="container">
            <div class="mb-2">
                <i class="bi bi-shield-check text-success"></i>
                নিরাপদ ও সরকারি অনুমোদিত অনলাইন সেবা
            </div>
            <div>
                &copy; {{ date('Y') }} <strong>{{ current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ' }}</strong>
                @if (current_union()?->phone)
                    | <i class="bi bi-telephone"></i> {{ current_union()->phone }}
                @endif
                @if (current_union()?->email)
                    | <i class="bi bi-envelope"></i> {{ current_union()->email }}
                @endif
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
