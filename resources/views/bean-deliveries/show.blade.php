@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Bean Delivery Details') }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('bean-deliveries.edit', $beanDelivery) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> {{ __('Edit') }}
            </a>
            <form action="{{ route('bean-deliveries.destroy', $beanDelivery) }}" method="POST" onsubmit="return confirm('{{ __('Are you sure you want to delete this delivery?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> {{ __('Delete') }}
                </button>
            </form>
            <a href="{{ route('bean-deliveries.index') }}" class="btn btn-secondary">
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
            <h5 class="mb-0">{{ __('Delivery Information') }}</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">{{ __('Batch Number') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->batch_number }}</dd>

                        <dt class="col-sm-5">{{ __('Supplier Name') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->supplier_name }}</dd>

                        <dt class="col-sm-5">{{ __('Origin Country') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->origin_country ?? '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Bean Type') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->bean_type ?? '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Delivery Date') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->delivery_date?->format('Y-m-d') ?? '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Quantity (kg)') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->quantity_kg ? number_format($beanDelivery->quantity_kg, 2) : '-' }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-5">{{ __('Moisture (%)') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->moisture_percentage ? number_format($beanDelivery->moisture_percentage, 2) : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Fat Content (%)') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->fat_content_percentage ? number_format($beanDelivery->fat_content_percentage, 2) : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Quality Grade') }}</dt>
                        <dd class="col-sm-7">
                            @if($beanDelivery->quality_grade)
                                <span class="badge bg-{{ $beanDelivery->quality_grade === 'A' ? 'success' : ($beanDelivery->quality_grade === 'B' ? 'primary' : ($beanDelivery->quality_grade === 'C' ? 'warning' : 'danger')) }}">
                                    {{ $beanDelivery->quality_grade }}
                                </span>
                            @else
                                -
                            @endif
                        </dd>

                        <dt class="col-sm-5">{{ __('Unit Price') }}</dt>
                        <dd class="col-sm-7">{{ $beanDelivery->unit_price ? number_format($beanDelivery->unit_price, 2) : '-' }}</dd>
                    </dl>
                </div>
            </div>

            @if($beanDelivery->notes)
                <div class="mt-3">
                    <h6>{{ __('Notes') }}</h6>
                    <p class="text-muted">{{ $beanDelivery->notes }}</p>
                </div>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">{{ __('Linked Production Orders') }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Order #') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Batch #') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Target Qty (kg)') }}</th>
                            <th>{{ __('Actual Qty (kg)') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beanDelivery->productionOrders ?? [] as $order)
                            <tr>
                                <td>{{ $order->order_number }}</td>
                                <td>
                                    <span class="badge bg-{{ $order->type === 'nibs' ? 'info' : 'dark' }}">
                                        {{ ucfirst($order->type) }}
                                    </span>
                                </td>
                                <td>{{ $order->batch_number }}</td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'planned' => 'secondary',
                                            'in_progress' => 'primary',
                                            'completed' => 'success',
                                            'cancelled' => 'danger',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                        {{ __(ucfirst(str_replace('_', ' ', $order->status))) }}
                                    </span>
                                </td>
                                <td>{{ number_format($order->target_quantity_kg, 2) }}</td>
                                <td>{{ $order->actual_quantity_kg ? number_format($order->actual_quantity_kg, 2) : '-' }}</td>
                                <td>
                                    <a href="{{ route('production-orders.show', $order) }}" class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-4">{{ __('No linked production orders.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
