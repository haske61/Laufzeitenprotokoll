@extends('layouts.app')

@section('content')
<div class="container">
    <div class="mb-4">
        <h1>{{ __('Edit Bean Delivery') }}</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('bean-deliveries.update', $beanDelivery) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="supplier_name" class="form-label">{{ __('Supplier Name') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('supplier_name') is-invalid @enderror" id="supplier_name" name="supplier_name" value="{{ old('supplier_name', $beanDelivery->supplier_name) }}" required>
                        @error('supplier_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="origin_country" class="form-label">{{ __('Origin Country') }}</label>
                        <input type="text" class="form-control @error('origin_country') is-invalid @enderror" id="origin_country" name="origin_country" value="{{ old('origin_country', $beanDelivery->origin_country) }}">
                        @error('origin_country')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="bean_type" class="form-label">{{ __('Bean Type') }}</label>
                        <input type="text" class="form-control @error('bean_type') is-invalid @enderror" id="bean_type" name="bean_type" value="{{ old('bean_type', $beanDelivery->bean_type) }}">
                        @error('bean_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="batch_number" class="form-label">{{ __('Batch Number') }} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('batch_number') is-invalid @enderror" id="batch_number" name="batch_number" value="{{ old('batch_number', $beanDelivery->batch_number) }}" required>
                        @error('batch_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="delivery_date" class="form-label">{{ __('Delivery Date') }}</label>
                        <input type="date" class="form-control @error('delivery_date') is-invalid @enderror" id="delivery_date" name="delivery_date" value="{{ old('delivery_date', $beanDelivery->delivery_date?->format('Y-m-d')) }}">
                        @error('delivery_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="quantity_kg" class="form-label">{{ __('Quantity (kg)') }}</label>
                        <input type="number" step="0.01" class="form-control @error('quantity_kg') is-invalid @enderror" id="quantity_kg" name="quantity_kg" value="{{ old('quantity_kg', $beanDelivery->quantity_kg) }}">
                        @error('quantity_kg')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="moisture_percentage" class="form-label">{{ __('Moisture (%)') }}</label>
                        <input type="number" step="0.01" class="form-control @error('moisture_percentage') is-invalid @enderror" id="moisture_percentage" name="moisture_percentage" value="{{ old('moisture_percentage', $beanDelivery->moisture_percentage) }}">
                        @error('moisture_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="fat_content_percentage" class="form-label">{{ __('Fat Content (%)') }}</label>
                        <input type="number" step="0.01" class="form-control @error('fat_content_percentage') is-invalid @enderror" id="fat_content_percentage" name="fat_content_percentage" value="{{ old('fat_content_percentage', $beanDelivery->fat_content_percentage) }}">
                        @error('fat_content_percentage')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-4">
                        <label for="quality_grade" class="form-label">{{ __('Quality Grade') }}</label>
                        <select class="form-select @error('quality_grade') is-invalid @enderror" id="quality_grade" name="quality_grade">
                            <option value="">{{ __('-- Select --') }}</option>
                            <option value="A" {{ old('quality_grade', $beanDelivery->quality_grade) === 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ old('quality_grade', $beanDelivery->quality_grade) === 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ old('quality_grade', $beanDelivery->quality_grade) === 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ old('quality_grade', $beanDelivery->quality_grade) === 'D' ? 'selected' : '' }}>D</option>
                        </select>
                        @error('quality_grade')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="unit_price" class="form-label">{{ __('Unit Price') }}</label>
                        <input type="number" step="0.01" class="form-control @error('unit_price') is-invalid @enderror" id="unit_price" name="unit_price" value="{{ old('unit_price', $beanDelivery->unit_price) }}">
                        @error('unit_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">{{ __('Notes') }}</label>
                    <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $beanDelivery->notes) }}</textarea>
                    @error('notes')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">{{ __('Update Delivery') }}</button>
                    <a href="{{ route('bean-deliveries.show', $beanDelivery) }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
