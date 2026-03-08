@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1>{{ __('Edit Production Order') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('production-orders.update', $productionOrder) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="order_number" class="form-label">{{ __('Order Number') }}</label>
                        <input type="text" class="form-control @error('order_number') is-invalid @enderror" id="order_number" name="order_number" value="{{ old('order_number', $productionOrder->order_number) }}" placeholder="{{ __('Auto-generated if empty') }}">
                        @error('order_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="type" class="form-label">{{ __('Type') }}</label>
                        <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                            <option value="">{{ __('-- Select --') }}</option>
                            <option value="nibs" {{ old('type', $productionOrder->type) === 'nibs' ? 'selected' : '' }}>{{ __('Nibs') }}</option>
                            <option value="mass" {{ old('type', $productionOrder->type) === 'mass' ? 'selected' : '' }}>{{ __('Mass') }}</option>
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
                                <option value="{{ $delivery->id }}" {{ old('bean_delivery_id', $productionOrder->bean_delivery_id) == $delivery->id ? 'selected' : '' }}>
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
                        <input type="text" class="form-control @error('batch_number') is-invalid @enderror" id="batch_number" name="batch_number" value="{{ old('batch_number', $productionOrder->batch_number) }}" required>
                        @error('batch_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="status" class="form-label">{{ __('Status') }}</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status">
                            <option value="planned" {{ old('status', $productionOrder->status) === 'planned' ? 'selected' : '' }}>{{ __('Planned') }}</option>
                            <option value="in_progress" {{ old('status', $productionOrder->status) === 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                            <option value="completed" {{ old('status', $productionOrder->status) === 'completed' ? 'selected' : '' }}>{{ __('Completed') }}</option>
                            <option value="cancelled" {{ old('status', $productionOrder->status) === 'cancelled' ? 'selected' : '' }}>{{ __('Cancelled') }}</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="target_quantity_kg" class="form-label">{{ __('Target Quantity (kg)') }} <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control @error('target_quantity_kg') is-invalid @enderror" id="target_quantity_kg" name="target_quantity_kg" value="{{ old('target_quantity_kg', $productionOrder->target_quantity_kg) }}" required>
                        @error('target_quantity_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="actual_quantity_kg" class="form-label">{{ __('Actual Quantity (kg)') }}</label>
                        <input type="number" step="0.01" class="form-control @error('actual_quantity_kg') is-invalid @enderror" id="actual_quantity_kg" name="actual_quantity_kg" value="{{ old('actual_quantity_kg', $productionOrder->actual_quantity_kg) }}">
                        @error('actual_quantity_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="planned_start" class="form-label">{{ __('Planned Start') }}</label>
                        <input type="datetime-local" class="form-control @error('planned_start') is-invalid @enderror" id="planned_start" name="planned_start" value="{{ old('planned_start', $productionOrder->planned_start ? \Carbon\Carbon::parse($productionOrder->planned_start)->format('Y-m-d\TH:i') : '') }}">
                        @error('planned_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="planned_end" class="form-label">{{ __('Planned End') }}</label>
                        <input type="datetime-local" class="form-control @error('planned_end') is-invalid @enderror" id="planned_end" name="planned_end" value="{{ old('planned_end', $productionOrder->planned_end ? \Carbon\Carbon::parse($productionOrder->planned_end)->format('Y-m-d\TH:i') : '') }}">
                        @error('planned_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="actual_start" class="form-label">{{ __('Actual Start') }}</label>
                        <input type="datetime-local" class="form-control @error('actual_start') is-invalid @enderror" id="actual_start" name="actual_start" value="{{ old('actual_start', $productionOrder->actual_start ? \Carbon\Carbon::parse($productionOrder->actual_start)->format('Y-m-d\TH:i') : '') }}">
                        @error('actual_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="actual_end" class="form-label">{{ __('Actual End') }}</label>
                        <input type="datetime-local" class="form-control @error('actual_end') is-invalid @enderror" id="actual_end" name="actual_end" value="{{ old('actual_end', $productionOrder->actual_end ? \Carbon\Carbon::parse($productionOrder->actual_end)->format('Y-m-d\TH:i') : '') }}">
                        @error('actual_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="operator_name" class="form-label">{{ __('Operator Name') }}</label>
                        <input type="text" class="form-control @error('operator_name') is-invalid @enderror" id="operator_name" name="operator_name" value="{{ old('operator_name', $productionOrder->operator_name) }}">
                        @error('operator_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="shift" class="form-label">{{ __('Shift') }}</label>
                        <select class="form-select @error('shift') is-invalid @enderror" id="shift" name="shift">
                            <option value="">{{ __('-- Select --') }}</option>
                            <option value="morning" {{ old('shift', $productionOrder->shift) === 'morning' ? 'selected' : '' }}>{{ __('Morning') }}</option>
                            <option value="afternoon" {{ old('shift', $productionOrder->shift) === 'afternoon' ? 'selected' : '' }}>{{ __('Afternoon') }}</option>
                            <option value="night" {{ old('shift', $productionOrder->shift) === 'night' ? 'selected' : '' }}>{{ __('Night') }}</option>
                        </select>
                        @error('shift')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $productionOrder->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('Update Order') }}</button>
                    <a href="{{ route('production-orders.show', $productionOrder) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
