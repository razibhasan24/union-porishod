<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'লগইন') — {{ current_union()?->name_bn ?? config('app.name') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        * {
            font-family: 'SolaimanLipi', 'Segoe UI', Tahoma, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0d6efd 0%, #0a4d8c 50%, #052c65 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            animation: move 30s linear infinite;
            pointer-events: none;
        }

        @keyframes move {
            from {
                transform: translate(0, 0);
            }

            to {
                transform: translate(40px, 40px);
            }
        }

        .auth-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            max-width: 1000px;
            width: 100%;
            position: relative;
            z-index: 1;
        }

        .auth-side {
            background: linear-gradient(160deg, #0d6efd 0%, #0a4d8c 100%);
            color: white;
            padding: 50px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 550px;
        }

        .auth-side h2 {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .auth-side .feature-list {
            list-style: none;
            padding: 0;
            margin: 30px 0;
        }

        .auth-side .feature-list li {
            padding: 10px 0;
            display: flex;
            align-items: center;
            font-size: 0.95rem;
            opacity: 0.95;
        }

        .auth-side .feature-list i {
            font-size: 1.3rem;
            margin-right: 12px;
            color: #ffd700;
        }

        .auth-form-side {
            padding: 50px 40px;
        }

        .form-control {
            padding: 12px 15px;
            border-radius: 10px;
            border: 2px solid #e5e7eb;
            transition: all 0.2s;
        }

        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 6px;
        }

        .input-group-text {
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-right: none;
            border-radius: 10px 0 0 10px;
        }

        .input-group .form-control {
            border-left: none;
            border-radius: 0 10px 10px 0;
        }

        .btn-login {
            background: linear-gradient(135deg, #0d6efd, #0a4d8c);
            border: none;
            padding: 13px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
            letter-spacing: 0.5px;
            transition: all 0.3s;
            color: white;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(13, 110, 253, 0.4);
            color: white;
        }

        .divider {
            text-align: center;
            margin: 25px 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: #e5e7eb;
        }

        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #6b7280;
            font-size: 0.85rem;
        }

        .alert {
            border-radius: 10px;
            border: none;
        }

        @media (max-width: 768px) {
            .auth-side {
                display: none;
            }

            .auth-form-side {
                padding: 35px 25px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-9">
                <div class="auth-card">
                    <div class="row g-0">
                        {{-- Left Side --}}
                        <div class="col-md-5">
                            <div class="auth-side">
                                <div>
                                    @if (current_union()?->logo)
                                        <img src="{{ asset('storage/' . current_union()->logo) }}"
                                            class="mb-3 rounded-circle bg-white p-1" width="70" height="70"
                                            style="object-fit: cover;" alt="Logo">
                                    @else
                                        <i class="bi bi-building" style="font-size: 50px; color: #ffd700;"></i>
                                    @endif
                                    <h2>{{ current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ' }}</h2>
                                    <p style="opacity: 0.9;">{{ current_union()?->upazila_bn ?? '' }}
                                        @if (current_union()?->district_bn)
                                            , {{ current_union()->district_bn }}
                                        @endif
                                    </p>

                                    <ul class="feature-list mt-4">
                                        <li><i class="bi bi-file-earmark-check"></i> অনলাইনে সার্টিফিকেট আবেদন</li>
                                        <li><i class="bi bi-credit-card"></i> নিরাপদ অনলাইন পেমেন্ট</li>
                                        <li><i class="bi bi-qr-code"></i> QR কোডে যাচাই</li>
                                        <li><i class="bi bi-phone"></i> SMS মাধ্যমে আপডেট</li>
                                        <li><i class="bi bi-shield-lock"></i> নিরাপদ ও বিশ্বস্ত সেবা</li>
                                    </ul>
                                </div>
                                <div style="opacity: 0.75; font-size: 0.85rem;">
                                    &copy; {{ date('Y') }} {{ current_union()?->name_bn ?? 'ইউনিয়ন পরিষদ' }}
                                </div>
                            </div>
                        </div>

                        {{-- Right Side (Form) --}}
                        <div class="col-md-7">
                            <div class="auth-form-side">
                                @yield('content')
                                {{-- এই লাইনটা Component Support এর জন্য --}}
                                {{ $slot ?? '' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <small style="color: rgba(255,255,255,0.8);">
                        <i class="bi bi-shield-check"></i>
                        নিরাপদ ও সরকারি অনুমোদিত সিস্টেম
                    </small>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
