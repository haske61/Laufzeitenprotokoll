@extends('layouts.app')

@section('content')
<div class="container">
    @php
        $statusColors = [
            'planned' => 'secondary',
            'in_progress' => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
        ];
    @endphp

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="d-inline-block me-3">{{ __('Production Order Details') }}</h1>
            <span class="badge bg-{{ $statusColors[$productionOrder->status] ?? 'secondary' }} fs-6">
                {{ __(ucfirst(str_replace('_', ' ', $productionOrder->status))) }}
            </span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('production-orders.edit', $productionOrder) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> {{ __('Edit') }}
            </a>
            <form action="{{ route('production-orders.destroy', $productionOrder) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this order?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> {{ __('Delete') }}
                </button>
            </form>
            <a href="{{ route('production-orders.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> {{ __('Back') }}
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Order Information') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">{{ __('Order Number') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->order_number }}</dd>

                        <dt class="col-sm-5">{{ __('Type') }}</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-{{ $productionOrder->type === 'nibs' ? 'info' : 'dark' }}">
                                {{ ucfirst($productionOrder->type) }}
                            </span>
                        </dd>

                        <dt class="col-sm-5">{{ __('Batch Number') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->batch_number }}</dd>

                        <dt class="col-sm-5">{{ __('Status') }}</dt>
                        <dd class="col-sm-7">
                            <span class="badge bg-{{ $statusColors[$productionOrder->status] ?? 'secondary' }}">
                                {{ __(ucfirst(str_replace('_', ' ', $productionOrder->status))) }}
                            </span>
                        </dd>

                        <dt class="col-sm-5">{{ __('Operator') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->operator_name ?? '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Shift') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->shift ? __(ucfirst($productionOrder->shift)) : '-' }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">{{ __('Target Qty (kg)') }}</dt>
                        <dd class="col-sm-7">{{ number_format($productionOrder->target_quantity_kg, 2) }}</dd>

                        <dt class="col-sm-5">{{ __('Actual Qty (kg)') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->actual_quantity_kg ? number_format($productionOrder->actual_quantity_kg, 2) : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Yield') }}</dt>
                        <dd class="col-sm-7">
                            @if($productionOrder->target_quantity_kg > 0 && $productionOrder->actual_quantity_kg)
                                {{ number_format(($productionOrder->actual_quantity_kg / $productionOrder->target_quantity_kg) * 100, 1) }}%
                            @else
                                -
                            @endif
                        </dd>

                        <dt class="col-sm-5">{{ __('Planned Start') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->planned_start ? \Carbon\Carbon::parse($productionOrder->planned_start)->format('Y-m-d H:i') : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Planned End') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->planned_end ? \Carbon\Carbon::parse($productionOrder->planned_end)->format('Y-m-d H:i') : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Actual Start') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->actual_start ? \Carbon\Carbon::parse($productionOrder->actual_start)->format('Y-m-d H:i') : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Actual End') }}</dt>
                        <dd class="col-sm-7">{{ $productionOrder->actual_end ? \Carbon\Carbon::parse($productionOrder->actual_end)->format('Y-m-d H:i') : '-' }}</dd>
                    </dl>
                </div>
            </div>

            @if($productionOrder->notes)
                <div class="mt-3">
                    <h6>{{ __('Notes') }}</h6>
                    <p class="text-muted">{{ $productionOrder->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    @if($productionOrder->beanDelivery)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Linked Bean Delivery') }}</h5>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-3">{{ __('Batch Number') }}</dt>
                    <dd class="col-sm-3">
                        <a href="{{ route('bean-deliveries.show', $productionOrder->beanDelivery) }}">
                            {{ $productionOrder->beanDelivery->batch_number }}
                        </a>
                    </dd>

                    <dt class="col-sm-3">{{ __('Supplier') }}</dt>
                    <dd class="col-sm-3">{{ $productionOrder->beanDelivery->supplier_name }}</dd>

                    <dt class="col-sm-3">{{ __('Origin') }}</dt>
                    <dd class="col-sm-3">{{ $productionOrder->beanDelivery->origin_country ?? '-' }}</dd>

                    <dt class="col-sm-3">{{ __('Quality Grade') }}</dt>
                    <dd class="col-sm-3">
                        @if($productionOrder->beanDelivery->quality_grade)
                            <span class="badge bg-{{ $productionOrder->beanDelivery->quality_grade === 'A' ? 'success' : ($productionOrder->beanDelivery->quality_grade === 'B' ? 'primary' : ($productionOrder->beanDelivery->quality_grade === 'C' ? 'warning' : 'danger')) }}">
                                {{ $productionOrder->beanDelivery->quality_grade }}
                            </span>
                        @else
                            -
                        @endif
                    </dd>
                </dl>
            </div>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Production Logs') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Machine') }}</th>
                            <th>{{ __('Start') }}</th>
                            <th>{{ __('End') }}</th>
                            <th>{{ __('Input Qty (kg)') }}</th>
                            <th>{{ __('Output Qty (kg)') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productionOrder->productionLogs ?? [] as $log)
                            <tr>
                                <td>{{ $log->machine }}</td>
                                <td>{{ $log->start ? \Carbon\Carbon::parse($log->start)->format('Y-m-d H:i') : '-' }}</td>
                                <td>{{ $log->end ? \Carbon\Carbon::parse($log->end)->format('Y-m-d H:i') : '-' }}</td>
                                <td>{{ $log->input_quantity_kg ? number_format($log->input_quantity_kg, 2) : '-' }}</td>
                                <td>{{ $log->output_quantity_kg ? number_format($log->output_quantity_kg, 2) : '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">{{ __('No production logs recorded.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Quality Checks') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Moisture (%)') }}</th>
                            <th>{{ __('Fat Content (%)') }}</th>
                            <th>{{ __('Passed') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productionOrder->qualityChecks ?? [] as $check)
                            <tr>
                                <td>{{ $check->checked_at ? \Carbon\Carbon::parse($check->checked_at)->format('Y-m-d H:i') : '-' }}</td>
                                <td>{{ $check->moisture_percentage ? number_format($check->moisture_percentage, 2) : '-' }}</td>
                                <td>{{ $check->fat_content_percentage ? number_format($check->fat_content_percentage, 2) : '-' }}</td>
                                <td>
                                    @if($check->passed)
                                        <span class="badge bg-success">{{ __('Yes') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('No') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-4">{{ __('No quality checks recorded.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
