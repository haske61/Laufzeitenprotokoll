@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Edit Breakdown') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('machine-breakdowns.update', $breakdown) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="machine_id" class="form-label">{{ __('Machine') }} <span class="text-danger">*</span></label>
                        <select name="machine_id" id="machine_id" class="form-select @error('machine_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Machine') }}</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}" {{ old('machine_id', $breakdown->machine_id) == $machine->id ? 'selected' : '' }}>
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
                            <option value="breakdown" {{ old('type', $breakdown->type) === 'breakdown' ? 'selected' : '' }}>{{ __('Breakdown') }}</option>
                            <option value="maintenance" {{ old('type', $breakdown->type) === 'maintenance' ? 'selected' : '' }}>{{ __('Maintenance') }}</option>
                            <option value="cleaning" {{ old('type', $breakdown->type) === 'cleaning' ? 'selected' : '' }}>{{ __('Cleaning') }}</option>
                            <option value="other" {{ old('type', $breakdown->type) === 'other' ? 'selected' : '' }}>{{ __('Other') }}</option>
                        </select>
                        @error('type')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-3">
                        <label for="severity" class="form-label">{{ __('Severity') }} <span class="text-danger">*</span></label>
                        <select name="severity" id="severity" class="form-select @error('severity') is-invalid @enderror" required>
                            <option value="low" {{ old('severity', $breakdown->severity) === 'low' ? 'selected' : '' }}>{{ __('Low') }}</option>
                            <option value="medium" {{ old('severity', $breakdown->severity) === 'medium' ? 'selected' : '' }}>{{ __('Medium') }}</option>
                            <option value="high" {{ old('severity', $breakdown->severity) === 'high' ? 'selected' : '' }}>{{ __('High') }}</option>
                            <option value="critical" {{ old('severity', $breakdown->severity) === 'critical' ? 'selected' : '' }}>{{ __('Critical') }}</option>
                        </select>
                        @error('severity')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="started_at" class="form-label">{{ __('Started At') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="started_at" id="started_at" class="form-control @error('started_at') is-invalid @enderror" value="{{ old('started_at', $breakdown->started_at?->format('Y-m-d\TH:i')) }}" required>
                        @error('started_at')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="ended_at" class="form-label">{{ __('Ended At') }}</label>
                        <input type="datetime-local" name="ended_at" id="ended_at" class="form-control @error('ended_at') is-invalid @enderror" value="{{ old('ended_at', $breakdown->ended_at?->format('Y-m-d\TH:i')) }}">
                        @error('ended_at')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">{{ __('Status') }} <span class="text-danger">*</span></label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="reported" {{ old('status', $breakdown->status) === 'reported' ? 'selected' : '' }}>{{ __('Reported') }}</option>
                            <option value="in_progress" {{ old('status', $breakdown->status) === 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                            <option value="resolved" {{ old('status', $breakdown->status) === 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                        </select>
                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">{{ __('Description') }} <span class="text-danger">*</span></label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror" required>{{ old('description', $breakdown->description) }}</textarea>
                    @error('description')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="cause" class="form-label">{{ __('Cause') }}</label>
                    <textarea name="cause" id="cause" rows="2" class="form-control @error('cause') is-invalid @enderror">{{ old('cause', $breakdown->cause) }}</textarea>
                    @error('cause')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="resolution" class="form-label">{{ __('Resolution') }}</label>
                    <textarea name="resolution" id="resolution" rows="2" class="form-control @error('resolution') is-invalid @enderror">{{ old('resolution', $breakdown->resolution) }}</textarea>
                    @error('resolution')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="parts_replaced" class="form-label">{{ __('Parts Replaced') }}</label>
                    <textarea name="parts_replaced" id="parts_replaced" rows="2" class="form-control @error('parts_replaced') is-invalid @enderror">{{ old('parts_replaced', $breakdown->parts_replaced) }}</textarea>
                    @error('parts_replaced')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> {{ __('Update') }}
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
