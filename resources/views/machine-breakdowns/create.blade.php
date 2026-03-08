@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Report Breakdown') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('machine-breakdowns.store') }}">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="machine_id" class="form-label">{{ __('Machine') }} <span class="text-danger">*</span></label>
                        <select name="machine_id" id="machine_id" class="form-select @error('machine_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Machine') }}</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}" {{ old('machine_id') == $machine->id ? 'selected' : '' }}>
                                    {{ $machine->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('machine_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="type" class="form-label">{{ __('Type') }} <span class="text-danger">*</span></label>
                        <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                            <option value="breakdown" {{ old('type') === 'breakdown' ? 'selected' : '' }}>{{ __('Breakdown') }}</option>
                            <option value="maintenance" {{ old('type') === 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                            <option value="cleaning" {{ old('type') === 'cleaning' ? 'selected' : '' }}>{{ __('Cleaning') }}</option>
                            <option value="other" {{ old('type') === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                        </select>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="severity" class="form-label">{{ __('Severity') }} <span class="text-danger">*</span></label>
                        <select name="severity" id="severity" class="form-select @error('severity') is-invalid @enderror" required>
                            <option value="low" {{ old('severity') === 'low' ? 'selected' : '' }}>{{ __('Low') }}</option>
                            <option value="medium" {{ old('severity', 'medium') === 'medium' ? 'selected' : '' }}>{{ __('Medium') }}</option>
                            <option value="high" {{ old('severity') === 'high' ? 'selected' : '' }}>{{ __('High') }}</option>
                            <option value="critical" {{ old('severity') === 'critical' ? 'selected' : '' }}>{{ __('Critical') }}</option>
                        </select>
                        @error('severity')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="started_at" class="form-label">{{ __('Started At') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="started_at" id="started_at" class="form-control @error('started_at') is-invalid @enderror" value="{{ old('started_at', now()->format('Y-m-d\TH:i')) }}" required>
                        @error('started_at')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="ended_at" class="form-label">{{ __('Ended At') }}</label>
                        <input type="datetime-local" name="ended_at" id="ended_at" class="form-control @error('ended_at') is-invalid @enderror" value="{{ old('ended_at') }}">
                        @error('ended_at')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cause" class="form-label">{{ __('Cause') }}</label>
                    <textarea name="cause" id="cause" rows="2" class="form-control @error('cause') is-invalid @enderror">{{ old('cause') }}</textarea>
                    @error('cause')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="parts_replaced" class="form-label">{{ __('Parts Replaced') }}</label>
                    <textarea name="parts_replaced" id="parts_replaced" rows="2" class="form-control @error('parts_replaced') is-invalid @enderror">{{ old('parts_replaced') }}</textarea>
                    @error('parts_replaced')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> {{ __('Submit') }}
                    </button>
                    <a href="{{ route('machine-breakdowns.index') }}" class="btn btn-secondary">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
