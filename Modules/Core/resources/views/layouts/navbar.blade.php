<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom px-4">
    <div class="container-fluid">
        <span class="navbar-brand mb-0 h1">@yield('title', 'ড্যাশবোর্ড')</span>

        <div class="ms-auto d-flex align-items-center">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ auth()->user()->photo_url }}" alt="" width="32" height="32" class="rounded-circle me-2">
                    <div>
                        <div class="fw-bold small">{{ auth()->user()->display_name }}</div>
                        <div class="text-muted" style="font-size: 11px;">{{ auth()->user()->user_type }}</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> প্রোফাইল</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> সেটিংস</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">
                                <i class="bi bi-box-arrow-right"></i> লগআউট
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>