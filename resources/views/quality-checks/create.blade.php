@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('New Quality Check') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('quality-checks.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="production_order_id" class="form-label">{{ __('Production Order') }} <span class="text-danger">*</span></label>
                        <select name="production_order_id" id="production_order_id" class="form-select @error('production_order_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Production Order') }}</option>
                            @foreach($productionOrders as $order)
                                <option value="{{ $order->id }}" {{ old('production_order_id') == $order->id ? 'selected' : '' }}>
                                    {{ $order->order_number }}
                                </option>
                            @endforeach
                        </select>
                        @error('production_order_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="checked_at" class="form-label">{{ __('Checked At') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="checked_at" id="checked_at" class="form-control @error('checked_at') is-invalid @enderror" value="{{ old('checked_at', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('checked_at')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="moisture_percentage" class="form-label">{{ __('Moisture (%)') }}</label>
                        <input type="number" step="0.01" name="moisture_percentage" id="moisture_percentage" class="form-control @error('moisture_percentage') is-invalid @enderror" value="{{ old('moisture_percentage') }}">
                        @error('moisture_percentage')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="fat_content_percentage" class="form-label">{{ __('Fat Content (%)') }}</label>
                        <input type="number" step="0.01" name="fat_content_percentage" id="fat_content_percentage" class="form-control @error('fat_content_percentage') is-invalid @enderror" value="{{ old('fat_content_percentage') }}">
                        @error('fat_content_percentage')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="particle_size_microns" class="form-label">{{ __('Particle Size (µm)') }}</label>
                        <input type="number" step="0.1" name="particle_size_microns" id="particle_size_microns" class="form-control @error('particle_size_microns') is-invalid @enderror" value="{{ old('particle_size_microns') }}">
                        @error('particle_size_microns')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="temperature" class="form-label">{{ __('Temperature') }}</label>
                        <input type="number" step="0.1" name="temperature" id="temperature" class="form-control @error('temperature') is-invalid @enderror" value="{{ old('temperature') }}">
                        @error('temperature')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="viscosity" class="form-label">{{ __('Viscosity') }}</label>
                        <input type="number" step="0.01" name="viscosity" id="viscosity" class="form-control @error('viscosity') is-invalid @enderror" value="{{ old('viscosity') }}">
                        @error('viscosity')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="ph_value" class="form-label">{{ __('pH Value') }}</label>
                        <input type="number" step="0.01" name="ph_value" id="ph_value" class="form-control @error('ph_value') is-invalid @enderror" value="{{ old('ph_value') }}">
                        @error('ph_value')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="hidden" name="passed" value="0">
                        <input type="checkbox" name="passed" id="passed" value="1" class="form-check-input @error('passed') is-invalid @enderror" {{ old('passed', '1') == '1' ? 'checked' : '' }}>
                        <label for="passed" class="form-check-label">{{ __('Passed') }}</label>
                    </div>
                    @error('passed')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> {{ __('Submit') }}
                    </button>
                    <a href="{{ route('quality-checks.index') }}" class="btn btn-secondary">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
