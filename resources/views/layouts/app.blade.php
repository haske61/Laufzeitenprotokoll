<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Laufzeitenprotokoll')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YcnS/1WR6zNg1OFb6B9O4qMoFbA0JmpPCiz" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f4f6f9;
        }
        main {
            flex: 1;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .stat-card {
            border: none;
            border-radius: 0.75rem;
            transition: transform 0.15s ease-in-out;
        }
        .stat-card:hover {
            transform: translateY(-2px);
        }
        .stat-card .card-body {
            padding: 1.5rem;
        }
        .stat-card .stat-icon {
            font-size: 2.5rem;
            opacity: 0.3;
        }
        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: 700;
        }
        footer {
            background-color: #212529;
            color: #adb5bd;
        }
    </style>

    @stack('styles')
</head>
<body>

    {{-- Top Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="bi bi-gear-wide-connected me-1"></i> Laufzeitenprotokoll
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#mainNavbar" aria-controls="mainNavbar"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">

                {{-- Left-side navigation (visible only when authenticated) --}}
                @auth
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    {{-- Dashboard --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                           href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>{{ __('nav.dashboard') }}
                        </a>
                    </li>

                    {{-- Lieferungen (Bean Deliveries) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('bean-deliveries.*') ? 'active' : '' }}"
                           href="{{ route('bean-deliveries.index') }}">
                            <i class="bi bi-truck me-1"></i>{{ __('nav.deliveries') }}
                        </a>
                    </li>

                    {{-- Produktionsaufträge (Production Orders) - Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('production-orders.*') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-clipboard-check me-1"></i>{{ __('nav.production_orders') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item" href="{{ route('production-orders.index', ['type' => 'nibs']) }}">
                                    <i class="bi bi-circle-fill me-1 text-warning" style="font-size: 0.5rem;"></i>
                                    {{ __('nav.production_orders_nibs') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('production-orders.index', ['type' => 'mass']) }}">
                                    <i class="bi bi-circle-fill me-1 text-info" style="font-size: 0.5rem;"></i>
                                    {{ __('nav.production_orders_mass') }}
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('production-orders.index') }}">
                                    <i class="bi bi-list-ul me-1"></i>{{ __('nav.production_orders_all') }}
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- Produktionsprotokolle (Production Logs) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('production-logs.*') ? 'active' : '' }}"
                           href="{{ route('production-logs.index') }}">
                            <i class="bi bi-journal-text me-1"></i>{{ __('nav.production_logs') }}
                        </a>
                    </li>

                    {{-- Maschinenstörungen (Machine Breakdowns) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('machine-breakdowns.*') ? 'active' : '' }}"
                           href="{{ route('machine-breakdowns.index') }}">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ __('nav.breakdowns') }}
                        </a>
                    </li>

                    {{-- Qualitätsprüfungen (Quality Checks) --}}
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('quality-checks.*') ? 'active' : '' }}"
                           href="{{ route('quality-checks.index') }}">
                            <i class="bi bi-check2-circle me-1"></i>{{ __('nav.quality_checks') }}
                        </a>
                    </li>

                    {{-- Admin Dropdown (only for admin users) --}}
                    @if(auth()->user()->is_admin ?? false)
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ request()->routeIs('admin.*') ? 'active' : '' }}"
                           href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-shield-lock me-1"></i>{{ __('nav.admin') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.machines.index') }}">
                                    <i class="bi bi-cpu me-1"></i>{{ __('nav.machines') }}
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.users.index') }}">
                                    <i class="bi bi-people me-1"></i>{{ __('nav.users') }}
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                </ul>
                @endauth

                {{-- Right-side navigation --}}
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">

                    {{-- Language Switcher --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-translate me-1"></i>
                            {{ app()->getLocale() === 'de' ? 'DE' : 'EN' }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === 'de' ? 'active' : '' }}"
                                   href="{{ url('locale/de') }}">
                                    Deutsch (DE)
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item {{ app()->getLocale() === 'en' ? 'active' : '' }}"
                                   href="{{ url('locale/en') }}">
                                    English (EN)
                                </a>
                            </li>
                        </ul>
                    </li>

                    {{-- User Dropdown / Login --}}
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right me-1"></i>{{ __('nav.logout') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('nav.login') }}
                        </a>
                    </li>
                    @endauth

                </ul>

            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    <div class="container-fluid mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-1"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-1"></i> {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-info-circle me-1"></i> {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-1"></i>
                <strong>{{ __('messages.validation_errors') }}</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    {{-- Main Content --}}
    <main class="container-fluid py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="py-3 mt-auto">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <small>&copy; {{ date('Y') }} Laufzeitenprotokoll. {{ __('footer.all_rights_reserved') }}</small>
                </div>
                <div class="col-md-6 text-md-end">
                    <small>{{ __('footer.cacao_production_tracking') }}</small>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>

    @stack('scripts')
</body>
</html>
