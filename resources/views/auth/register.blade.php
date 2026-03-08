@extends('layouts.app')

@section('title', __('auth.register') . ' - Laufzeitenprotokoll')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-5 col-lg-4">

        <div class="text-center mb-4">
            <i class="bi bi-gear-wide-connected text-primary" style="font-size: 3rem;"></i>
            <h3 class="mt-2 fw-bold">Laufzeitenprotokoll</h3>
            <p class="text-muted">{{ __('auth.register_subtitle') }}</p>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="card-title mb-4 text-center">{{ __('auth.register') }}</h5>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Name --}}
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('auth.name') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   placeholder="{{ __('auth.name_placeholder') }}"
                                   required
                                   autofocus>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

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
                                   required>
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

                    {{-- Password Confirmation --}}
                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('auth.password_confirmation') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   placeholder="{{ __('auth.password_confirmation_placeholder') }}"
                                   required>
                        </div>
                    </div>

                    {{-- Register Button --}}
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-person-plus me-1"></i>{{ __('auth.register') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Login Link --}}
        <div class="text-center mt-3">
            <p class="text-muted">
                {{ __('auth.already_have_account') }}
                <a href="{{ route('login') }}" class="text-decoration-none">
                    {{ __('auth.login') }}
                </a>
            </p>
        </div>

    </div>
</div>
@endsection
