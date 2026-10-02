@php
    $user = auth()->user();
    $union = current_union();
    $locale = app()->getLocale();
@endphp

<div class="position-fixed top-0 start-0 bg-dark text-white vh-100 d-flex flex-column"
    style="width: 260px; overflow-y: auto; z-index: 1030;">

    {{-- ================= HEADER ================= --}}
    <div class="text-center py-3 border-bottom border-secondary">
        @if ($union?->logo)
            <img src="{{ asset('storage/' . $union->logo) }}" alt="Logo" class="mb-2 rounded-circle bg-white p-1"
                style="width: 55px; height: 55px; object-fit: cover;">
        @else
            <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                style="width: 55px; height: 55px;">
                <i class="bi bi-building text-dark fs-3"></i>
            </div>
        @endif

        <h6 class="text-warning mb-0 px-2">
            {{ $union?->name_bn ?? 'ইউনিয়ন পরিষদ' }}
        </h6>
        <small class="text-muted d-block" style="font-size: 11px;">
            {{ $union?->upazila_bn ?? '' }}
            @if ($union?->district_bn)
                , {{ $union->district_bn }}
            @endif
        </small>
    </div>

    {{-- ================= USER CARD ================= --}}
    <div class="px-3 py-3 border-bottom border-secondary">
        <div class="d-flex align-items-center">
            <img src="{{ $user->photo_url ?? asset('images/default-avatar.png') }}"
                class="rounded-circle me-2 border border-2 border-warning"
                style="width: 42px; height: 42px; object-fit: cover;" alt="User">
            <div class="flex-grow-1 overflow-hidden">
                <div class="text-white fw-bold text-truncate" style="font-size: 13px;">
                    {{ $user->display_name ?? $user->name }}
                </div>
                <small class="text-muted d-block text-truncate" style="font-size: 11px;">
                    @php
                        $userTypeLabel =
                            \Modules\Core\Enums\UserType::tryFrom($user->user_type)?->labelBn() ?? $user->user_type;
                    @endphp
                    {{ $userTypeLabel }}
                </small>
            </div>
        </div>
    </div>

    {{-- ================= NAVIGATION ================= --}}
    <ul class="nav flex-column px-2 py-3 flex-grow-1">

        {{-- Dashboard --}}
        <li class="nav-item mb-1">
            <a href="{{ route('core.dashboard') }}"
                class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('core.dashboard') ? 'active bg-primary' : 'hover-bg' }}">
                <i class="bi bi-speedometer2 me-2"></i>
                <span>ড্যাশবোর্ড</span>
            </a>
        </li>

        {{-- ================= CORE SECTION ================= --}}
        @if (auth()->user()->canany(['union.view', 'ward.view', 'village.view']) ||
                auth()->user()->canany(['user.view', 'role.view', 'permission.view', 'setting.view']))
            <li class="nav-item mt-3 mb-1">
                <small class="text-uppercase text-muted px-3" style="font-size: 10px; letter-spacing: 1px;">
                    প্রশাসন
                </small>
            </li>
        @endif

        @can('union.view')
            <li class="nav-item mb-1">
                <a href="{{ route('core.unions.index') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('core.unions.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-building me-2"></i>
                    <span>ইউনিয়ন</span>
                </a>
            </li>
        @endcan

        @can('ward.view')
            <li class="nav-item mb-1">
                <a href="{{ route('core.wards.index') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('core.wards.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-diagram-3 me-2"></i>
                    <span>ওয়ার্ড</span>
                </a>
            </li>
        @endcan

        @can('village.view')
            <li class="nav-item mb-1">
                <a href="{{ route('core.villages.index') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('core.villages.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-house-door me-2"></i>
                    <span>গ্রাম</span>
                </a>
            </li>
        @endcan

        @can('user.view')
            <li class="nav-item mb-1">
                <a href="{{ route('core.users.index') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('core.users.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-people me-2"></i>
                    <span>ইউজার</span>
                </a>
            </li>
        @endcan

        @can('role.view')
            <li class="nav-item mb-1">
                <a href="{{ route('core.roles.index') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('core.roles.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-shield-lock me-2"></i>
                    <span>রোল</span>
                </a>
            </li>
        @endcan

        @can('permission.view')
            <li class="nav-item mb-1">
                <a href="{{ route('core.permissions.index') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('core.permissions.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-key me-2"></i>
                    <span>পারমিশন</span>
                </a>
            </li>
        @endcan

        @can('setting.view')
            <li class="nav-item mb-1">
                <a href="{{ route('core.settings.index') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('core.settings.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-gear me-2"></i>
                    <span>সেটিংস</span>
                </a>
            </li>
        @endcan


        {{-- ================= CERTIFICATE SECTION ================= --}}
        {{-- ভবিষ্যতে Certificate module যোগ হলে un-comment করবেন --}}
        @if (class_exists(\Modules\Certificate\Models\CertificateType::class))
            @if (auth()->user()->canany(['certificate_type.view', 'certificate_application.view', 'certificate.view']))
                <li class="nav-item mt-3 mb-1">
                    <small class="text-uppercase text-muted px-3" style="font-size: 10px; letter-spacing: 1px;">
                        সার্টিফিকেট
                    </small>
                </li>

                @can('certificate_type.view')
                    <li class="nav-item mb-1">
                        <a href="{{ route('certificate.types.index') }}"
                            class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('certificate.types.*') ? 'active bg-primary' : 'hover-bg' }}">
                            <i class="bi bi-file-earmark-text me-2"></i>
                            <span>সার্টিফিকেট ধরন</span>
                        </a>
                    </li>
                @endcan

                @can('certificate_application.view')
                    <li class="nav-item mb-1">
                        <a href="{{ route('certificate.applications.index') }}"
                            class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('certificate.applications.*') ? 'active bg-primary' : 'hover-bg' }}">
                            <i class="bi bi-file-earmark-check me-2"></i>
                            <span>আবেদন তালিকা</span>
                        </a>
                    </li>
                @endcan

                @if (auth()->user()->isWardMember())
                    <li class="nav-item mb-1">
                        <a href="{{ route('certificate.applications.pending') }}"
                            class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('certificate.applications.pending') ? 'active bg-warning text-dark' : 'hover-bg' }}">
                            <i class="bi bi-hourglass-split me-2"></i>
                            <span>যাচাইয়ের অপেক্ষায়</span>
                            @php
                                $pendingCount = \Modules\Certificate\Models\CertificateApplication::where(
                                    'ward_id',
                                    auth()->user()->ward_id,
                                )
                                    ->where('status', 'sent_to_ward')
                                    ->count();
                            @endphp
                            @if ($pendingCount > 0)
                                <span class="badge bg-danger float-end">{{ bangla_number($pendingCount) }}</span>
                            @endif
                        </a>
                    </li>
                @endif

                @if (auth()->user()->isChairman())
                    <li class="nav-item mb-1">
                        <a href="{{ route('certificate.applications.pending-chairman') }}"
                            class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('certificate.applications.pending-chairman') ? 'active bg-warning text-dark' : 'hover-bg' }}">
                            <i class="bi bi-hourglass-split me-2"></i>
                            <span>অনুমোদনের অপেক্ষায়</span>
                            @php
                                $pendingApproval = \Modules\Certificate\Models\CertificateApplication::where(
                                    'status',
                                    'sent_to_chairman',
                                )->count();
                            @endphp
                            @if ($pendingApproval > 0)
                                <span class="badge bg-danger float-end">{{ bangla_number($pendingApproval) }}</span>
                            @endif
                        </a>
                    </li>
                @endif
            @endif
        @endif


        {{-- ================= APPLICANT SECTION ================= --}}
        @if (class_exists(\Modules\Payment\Models\Payment::class))
        @canany(['certificate_application.view', 'certificate_application.approve'])
            <li class="nav-item mt-3 mb-1">
                <small class="text-uppercase text-muted px-3" style="font-size: 10px; letter-spacing: 1px;">
                    পেমেন্ট
                </small>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('payment.admin.index') }}"
                class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('payment.admin.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-credit-card me-2"></i>
                    <span>পেমেন্ট তালিকা</span>
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('payment.admin.cash-entry') }}"
                class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('payment.admin.cash-entry') ? 'active bg-success' : 'hover-bg' }}">
                    <i class="bi bi-cash-coin me-2"></i>
                    <span>নগদ পেমেন্ট এন্ট্রি</span>
                </a>
            </li>
        @endcanany
    @endif
        @if (class_exists(\Modules\Applicant\Providers\ApplicantServiceProvider::class) && auth()->user()->isApplicant())
            <li class="nav-item mt-3 mb-1">
                <small class="text-uppercase text-muted px-3" style="font-size: 10px; letter-spacing: 1px;">
                    আমার কার্যক্রম
                </small>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('applicant.dashboard') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('applicant.dashboard') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-speedometer me-2"></i>
                    <span>আমার ড্যাশবোর্ড</span>
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('applicant.applications.index') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('applicant.applications.*') ? 'active bg-primary' : 'hover-bg' }}">
                    <i class="bi bi-file-earmark-text me-2"></i>
                    <span>আমার আবেদন</span>
                </a>
            </li>

            <li class="nav-item mb-1">
                <a href="{{ route('applicant.applications.create') }}"
                    class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('applicant.applications.create') ? 'active bg-success' : 'hover-bg' }}">
                    <i class="bi bi-plus-circle me-2"></i>
                    <span>নতুন আবেদন</span>
                </a>
            </li>
        @endif


        {{-- ================= ACCOUNTS SECTION ================= --}}
        {{-- ভবিষ্যতে Accounts module যোগ হলে un-comment করবেন --}}
        @if (class_exists(\Modules\Accounts\Models\Account::class))
            @if (auth()->user()->canany(['account.view', 'voucher.view', 'budget.view', 'report.view']))
                <li class="nav-item mt-3 mb-1">
                    <small class="text-uppercase text-muted px-3" style="font-size: 10px; letter-spacing: 1px;">
                        হিসাব
                    </small>
                </li>

                @can('account.view')
                    <li class="nav-item mb-1">
                        <a href="{{ route('accounts.accounts.index') }}"
                            class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('accounts.accounts.*') ? 'active bg-primary' : 'hover-bg' }}">
                            <i class="bi bi-journal-text me-2"></i>
                            <span>চার্ট অফ অ্যাকাউন্টস</span>
                        </a>
                    </li>
                @endcan

                @can('voucher.view')
                    <li class="nav-item mb-1">
                        <a href="{{ route('accounts.vouchers.index') }}"
                            class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('accounts.vouchers.*') ? 'active bg-primary' : 'hover-bg' }}">
                            <i class="bi bi-receipt me-2"></i>
                            <span>ভাউচার</span>
                        </a>
                    </li>
                @endcan

                @can('budget.view')
                    <li class="nav-item mb-1">
                        <a href="{{ route('accounts.budgets.index') }}"
                            class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('accounts.budgets.*') ? 'active bg-primary' : 'hover-bg' }}">
                            <i class="bi bi-pie-chart me-2"></i>
                            <span>বাজেট</span>
                        </a>
                    </li>
                @endcan
            @endif
        @endif


    {{-- ================= REPORT SECTION ================= --}}
{{--     
@if (\Illuminate\Support\Facades\Route::has('report.dashboard'))
    @can('report.view')
        <li class="nav-item mt-3 mb-1">
            <small class="text-uppercase text-muted px-3" style="font-size: 10px; letter-spacing: 1px;">
                রিপোর্ট
            </small>
        </li>
        <li class="nav-item mb-1">
            <a href="{{ route('report.dashboard') }}"
                class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('report.dashboard') ? 'active bg-primary' : 'hover-bg' }}">
                <i class="bi bi-graph-up me-2"></i>
                <span>রিপোর্ট ড্যাশবোর্ড</span>
            </a>
        </li>
    @endcan
@endif --}}



        {{-- ================= MY PROFILE ================= --}}
        <li class="nav-item mt-3 mb-1">
            <small class="text-uppercase text-muted px-3" style="font-size: 10px; letter-spacing: 1px;">
                ব্যক্তিগত
            </small>
        </li>

        <li class="nav-item mb-1">
            <a href="{{ route('profile.edit') ?? '#' }}"
                class="nav-link text-white rounded px-3 py-2 {{ request()->routeIs('profile.*') ? 'active bg-primary' : 'hover-bg' }}">
                <i class="bi bi-person me-2"></i>
                <span>আমার প্রোফাইল</span>
            </a>
        </li>

    </ul>

    {{-- ================= FOOTER ================= --}}
    <div class="border-top border-secondary p-3 mt-auto">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                <i class="bi bi-box-arrow-right me-1"></i> লগআউট
            </button>
        </form>

        <div class="text-center mt-2">
            <small class="text-muted" style="font-size: 10px;">
                &copy; {{ date('Y') }} {{ $union?->name_bn ?? 'ইউনিয়ন পরিষদ' }}
            </small>
        </div>
    </div>

</div>

{{-- ================= HOVER EFFECT CSS ================= --}}
@push('styles')
    <style>
        .hover-bg {
            transition: all 0.2s ease;
        }

        .hover-bg:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            transform: translateX(3px);
        }

        .nav-link.active {
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(13, 110, 253, 0.4);
        }

        /* Scrollbar beautify */
        .position-fixed::-webkit-scrollbar {
            width: 6px;
        }

        .position-fixed::-webkit-scrollbar-thumb {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 3px;
        }

        .position-fixed::-webkit-scrollbar-thumb:hover {
            background-color: rgba(255, 255, 255, 0.4);
        }
    </style>
@endpush
