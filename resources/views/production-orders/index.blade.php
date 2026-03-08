@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Production Orders') }}</h1>
        <a href="{{ route('production-orders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('New Order') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    <div class="mb-3">
        <div class="btn-group" role="group" aria-label="{{ __('Filter by type') }}">
            <a href="{{ route('production-orders.index') }}" class="btn btn-outline-secondary {{ !request('type') ? 'active' : '' }}">
                {{ __('All') }}
            </a>
            <a href="{{ route('production-orders.index', ['type' => 'nibs']) }}" class="btn btn-outline-info {{ request('type') === 'nibs' ? 'active' : '' }}">
                {{ __('Nibs') }}
            </a>
            <a href="{{ route('production-orders.index', ['type' => 'mass']) }}" class="btn btn-outline-dark {{ request('type') === 'mass' ? 'active' : '' }}">
                {{ __('Mass') }}
            </a>
        </div>
    </div>

    <div class="card">
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
                            <th>{{ __('Yield %') }}</th>
                            <th>{{ __('Start Date') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productionOrders as $order)
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
                                    @if($order->target_quantity_kg > 0 && $order->actual_quantity_kg)
                                        {{ number_format(($order->actual_quantity_kg / $order->target_quantity_kg) * 100, 1) }}%
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>{{ $order->planned_start ? \Carbon\Carbon::parse($order->planned_start)->format('Y-m-d H:i') : '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('production-orders.show', $order) }}" class="btn btn-outline-info" title="{{ __('View') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('production-orders.edit', $order) }}" class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('production-orders.destroy', $order) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this order?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="{{ __('Delete') }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">{{ __('No production orders found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($productionOrders->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $productionOrders->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
