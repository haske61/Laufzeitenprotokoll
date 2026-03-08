@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1>{{ __('New Production Order') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('production-orders.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="order_number" class="form-label">{{ __('Order Number') }}</label>
                        <input type="text" class="form-control @error('order_number') is-invalid @enderror" id="order_number" name="order_number" value="{{ old('order_number') }}" placeholder="{{ __('Auto-generated if empty') }}">
                        @error('order_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">{{ __('Type') }}</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="">{{ __('-- Select --') }}</option>
                            <option value="nibs" {{ old('type') === 'nibs' ? 'selected' : '' }}>{{ __('Nibs') }}</option>
                            <option value="mass" {{ old('type') === 'mass' ? 'selected' : '' }}>{{ __('Mass') }}</option>
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bean_delivery_id" class="form-label">{{ __('Bean Delivery') }}</label>
                        <select class="form-select @error('bean_delivery_id') is-invalid @enderror" id="bean_delivery_id" name="bean_delivery_id">
                            <option value="">{{ __('-- Select --') }}</option>
                            @foreach($beanDeliveries as $delivery)
                                <option value="{{ $delivery->id }}" {{ old('bean_delivery_id') == $delivery->id ? 'selected' : '' }}>
                                    {{ $delivery->batch_number }} - {{ $delivery->supplier_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('bean_delivery_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="batch_number" class="form-label">{{ __('Batch Number') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('batch_number') is-invalid @enderror" id="batch_number" name="batch_number" value="{{ old('batch_number') }}" required>
                        @error('batch_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="target_quantity_kg" class="form-label">{{ __('Target Quantity (kg)') }} <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('target_quantity_kg') is-invalid @enderror" id="target_quantity_kg" name="target_quantity_kg" value="{{ old('target_quantity_kg') }}" required>
                        @error('target_quantity_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="planned_start" class="form-label">{{ __('Planned Start') }}</label>
                        <input type="datetime-local" class="form-control @error('planned_start') is-invalid @enderror" id="planned_start" name="planned_start" value="{{ old('planned_start') }}">
                        @error('planned_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="planned_end" class="form-label">{{ __('Planned End') }}</label>
                        <input type="datetime-local" class="form-control @error('planned_end') is-invalid @enderror" id="planned_end" name="planned_end" value="{{ old('planned_end') }}">
                        @error('planned_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="operator_name" class="form-label">{{ __('Operator Name') }}</label>
                        <input type="text" class="form-control @error('operator_name') is-invalid @enderror" id="operator_name" name="operator_name" value="{{ old('operator_name') }}">
                        @error('operator_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="shift" class="form-label">{{ __('Shift') }}</label>
                        <select class="form-select @error('shift') is-invalid @enderror" id="shift" name="shift">
                            <option value="">{{ __('-- Select --') }}</option>
                            <option value="morning" {{ old('shift') === 'morning' ? 'selected' : '' }}>{{ __('Morning') }}</option>
                            <option value="afternoon" {{ old('shift') === 'afternoon' ? 'selected' : '' }}>{{ __('Afternoon') }}</option>
                            <option value="night" {{ old('shift') === 'night' ? 'selected' : '' }}>{{ __('Night') }}</option>
                        </select>
                        @error('shift')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('Create Order') }}</button>
                    <a href="{{ route('production-orders.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
