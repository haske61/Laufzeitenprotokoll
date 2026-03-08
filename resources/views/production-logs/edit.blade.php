@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Edit Production Log') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('production-logs.update', $productionLog) }}">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="production_order_id" class="form-label">{{ __('Production Order') }} <span class="text-danger">*</span></label>
                        <select name="production_order_id" id="production_order_id" class="form-select @error('production_order_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Production Order') }}</option>
                            @foreach($productionOrders as $order)
                                <option value="{{ $order->id }}" {{ old('production_order_id', $productionLog->production_order_id) == $order->id ? 'selected' : '' }}>
                                    {{ $order->order_number }} - {{ ucfirst($order->type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('production_order_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="machine_id" class="form-label">{{ __('Machine') }} <span class="text-danger">*</span></label>
                        <select name="machine_id" id="machine_id" class="form-select @error('machine_id') is-invalid @enderror" required>
                            <option value="">{{ __('Select Machine') }}</option>
                            @foreach($machines as $machine)
                                <option value="{{ $machine->id }}" {{ old('machine_id', $productionLog->machine_id) == $machine->id ? 'selected' : '' }}>
                                    {{ $machine->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('machine_id')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="started_at" class="form-label">{{ __('Started At') }} <span class="text-danger">*</span></label>
                        <input type="datetime-local" name="started_at" id="started_at" class="form-control @error('started_at') is-invalid @enderror" value="{{ old('started_at', $productionLog->started_at?->format('Y-m-d\TH:i')) }}" required>
                        @error('started_at')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="ended_at" class="form-label">{{ __('Ended At') }}</label>
                        <input type="datetime-local" name="ended_at" id="ended_at" class="form-control @error('ended_at') is-invalid @enderror" value="{{ old('ended_at', $productionLog->ended_at?->format('Y-m-d\TH:i')) }}">
                        @error('ended_at')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="input_quantity_kg" class="form-label">{{ __('Input Quantity (kg)') }}</label>
                        <input type="number" step="0.01" name="input_quantity_kg" id="input_quantity_kg" class="form-control @error('input_quantity_kg') is-invalid @enderror" value="{{ old('input_quantity_kg', $productionLog->input_quantity_kg) }}">
                        @error('input_quantity_kg')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="output_quantity_kg" class="form-label">{{ __('Output Quantity (kg)') }}</label>
                        <input type="number" step="0.01" name="output_quantity_kg" id="output_quantity_kg" class="form-control @error('output_quantity_kg') is-invalid @enderror" value="{{ old('output_quantity_kg', $productionLog->output_quantity_kg) }}">
                        @error('output_quantity_kg')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="temperature" class="form-label">{{ __('Temperature') }}</label>
                        <input type="number" step="0.1" name="temperature" id="temperature" class="form-control @error('temperature') is-invalid @enderror" value="{{ old('temperature', $productionLog->temperature) }}">
                        @error('temperature')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="humidity" class="form-label">{{ __('Humidity') }}</label>
                        <input type="number" step="0.1" name="humidity" id="humidity" class="form-control @error('humidity') is-invalid @enderror" value="{{ old('humidity', $productionLog->humidity) }}">
                        @error('humidity')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                    <textarea name="notes" id="notes" rows="3" class="form-control @error('notes') is-invalid @enderror">{{ old('notes', $productionLog->notes) }}</textarea>
                    @error('notes')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg"></i> {{ __('Update') }}
                    </button>
                    <a href="{{ route('production-logs.index') }}" class="btn btn-secondary">
                        {{ __('Cancel') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
