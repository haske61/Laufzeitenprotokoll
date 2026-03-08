@extends('layouts.app')

@section('title', __('auth.login') . ' - Laufzeitenprotokoll')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5 col-lg-4">

        <div class="text-center mb-4">
            <i class="bi bi-gear-wide-connected text-primary" style="font-size: 3rem;"></i>
            <h3 class="mt-2 fw-bold">Laufzeitenprotokoll</h3>
            <p class="text-muted">{{ __('auth.login_subtitle') }}</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="card-title mb-4 text-center">{{ __('auth.login') }}</h5>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('auth.email') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   placeholder="{{ __('auth.email_placeholder') }}"
                                   required
                                   autofocus>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Password --}}
                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('auth.password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   placeholder="{{ __('auth.password_placeholder') }}"
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Remember Me --}}
                    <div class="mb-3 form-check">
                        <input type="checkbox"
                               class="form-check-input"
                               id="remember"
                               name="remember"
                               {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                            {{ __('auth.remember_me') }}
                        </label>
                    </div>

                    {{-- Login Button --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right me-1"></i>{{ __('auth.login') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route('dashboard') }}" class="text-muted text-decoration-none">
                <i class="bi bi-arrow-left me-1"></i>{{ __('common.back') }}
            </a>
        </div>

    </div>
</div>
@endsection
