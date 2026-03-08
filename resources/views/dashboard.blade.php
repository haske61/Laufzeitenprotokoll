@extends('layouts.app')

@section('title', __('nav.dashboard') . ' - Laufzeitenprotokoll')

@section('content')

{{-- Page Header --}}
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1">{{ __('dashboard.title') }}</h2>
        <p class="text-muted mb-0">{{ __('dashboard.welcome', ['name' => Auth::user()->name ?? '']) }}</p>
    </div>
    <div>
        <span class="text-muted">
            <i class="bi bi-calendar3 me-1"></i>{{ now()->translatedFormat('l, d. F Y') }}
        </span>
    </div>
</div>

{{-- Quick Action Buttons --}}
<div class="mb-4">
    <a href="{{ route('bean-deliveries.create') }}" class="btn btn-primary me-2">
        <i class="bi bi-plus-circle me-1"></i>{{ __('dashboard.new_delivery') }}
    </a>
    <a href="{{ route('production-orders.create') }}" class="btn btn-success me-2">
        <i class="bi bi-plus-circle me-1"></i>{{ __('dashboard.new_production_order') }}
    </a>
    <a href="{{ route('machine-breakdowns.create') }}" class="btn btn-warning me-2">
        <i class="bi bi-plus-circle me-1"></i>{{ __('dashboard.report_breakdown') }}
    </a>
</div>

{{-- Statistics Cards --}}
<div class="row g-4 mb-4">

    {{-- Total Bean Deliveries --}}
    <div class="col-md-3 col-sm-6">
        <div class="card stat-card bg-primary text-white shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-uppercase small fw-semibold opacity-75">
                        {{ __('dashboard.total_deliveries') }}
                    </div>
                    <div class="stat-value">{{ $totalDeliveries ?? 0 }}</div>
                    <div class="small opacity-75">
                        {{ number_format($totalDeliveryQuantity ?? 0, 1) }} kg {{ __('dashboard.total_quantity') }}
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-truck"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Active Production Orders --}}
    <div class="col-md-3 col-sm-6">
        <div class="card stat-card bg-success text-white shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-uppercase small fw-semibold opacity-75">
                        {{ __('dashboard.active_orders') }}
                    </div>
                    <div class="stat-value">{{ $activeOrders ?? 0 }}</div>
                    <div class="small opacity-75">
                        {{ $nibsCount ?? 0 }} Nibs / {{ $massCount ?? 0 }} Mass
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-clipboard-check"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Active Machine Breakdowns --}}
    <div class="col-md-3 col-sm-6">
        <div class="card stat-card bg-warning text-dark shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-uppercase small fw-semibold opacity-75">
                        {{ __('dashboard.active_breakdowns') }}
                    </div>
                    <div class="stat-value">{{ $activeBreakdowns ?? 0 }}</div>
                    <div class="small opacity-75">
                        {{ __('dashboard.machines_affected') }}
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Total Machines --}}
    <div class="col-md-3 col-sm-6">
        <div class="card stat-card bg-info text-white shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-uppercase small fw-semibold opacity-75">
                        {{ __('dashboard.total_machines') }}
                    </div>
                    <div class="stat-value">{{ $totalMachines ?? 0 }}</div>
                    <div class="small opacity-75">
                        {{ __('dashboard.registered_machines') }}
                    </div>
                </div>
                <div class="stat-icon">
                    <i class="bi bi-cpu"></i>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Recent Activity Section --}}
<div class="row">
    <div class="col-md-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white">
                <ul class="nav nav-tabs card-header-tabs" id="activityTabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="deliveries-tab" data-bs-toggle="tab"
                                data-bs-target="#deliveries-pane" type="button" role="tab"
                                aria-controls="deliveries-pane" aria-selected="true">
                            <i class="bi bi-truck me-1"></i>{{ __('dashboard.recent_deliveries') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="orders-tab" data-bs-toggle="tab"
                                data-bs-target="#orders-pane" type="button" role="tab"
                                aria-controls="orders-pane" aria-selected="false">
                            <i class="bi bi-clipboard-check me-1"></i>{{ __('dashboard.recent_orders') }}
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="breakdowns-tab" data-bs-toggle="tab"
                                data-bs-target="#breakdowns-pane" type="button" role="tab"
                                aria-controls="breakdowns-pane" aria-selected="false">
                            <i class="bi bi-exclamation-triangle me-1"></i>{{ __('dashboard.recent_breakdowns') }}
                        </button>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="activityTabsContent">

                    {{-- Recent Deliveries Tab --}}
                    <div class="tab-pane fade show active" id="deliveries-pane" role="tabpanel"
                         aria-labelledby="deliveries-tab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('dashboard.delivery_date') }}</th>
                                        <th>{{ __('dashboard.supplier') }}</th>
                                        <th>{{ __('dashboard.origin') }}</th>
                                        <th>{{ __('dashboard.quantity') }}</th>
                                        <th>{{ __('dashboard.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(($recentDeliveries ?? []) as $delivery)
                                    <tr>
                                        <td>{{ $delivery->delivery_date?->format('d.m.Y') }}</td>
                                        <td>{{ $delivery->supplier }}</td>
                                        <td>{{ $delivery->origin_country }}</td>
                                        <td>{{ number_format($delivery->quantity_kg, 1) }} kg</td>
                                        <td>
                                            <span class="badge bg-{{ $delivery->status === 'received' ? 'success' : ($delivery->status === 'pending' ? 'warning' : 'secondary') }}">
                                                {{ __('status.' . $delivery->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox me-1"></i>{{ __('dashboard.no_recent_deliveries') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Recent Production Orders Tab --}}
                    <div class="tab-pane fade" id="orders-pane" role="tabpanel"
                         aria-labelledby="orders-tab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('dashboard.order_number') }}</th>
                                        <th>{{ __('dashboard.type') }}</th>
                                        <th>{{ __('dashboard.machine') }}</th>
                                        <th>{{ __('dashboard.planned_quantity') }}</th>
                                        <th>{{ __('dashboard.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(($recentOrders ?? []) as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('production-orders.show', $order) }}" class="text-decoration-none">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order->type === 'nibs' ? 'warning' : 'info' }}">
                                                {{ ucfirst($order->type) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->machine?->name }}</td>
                                        <td>{{ number_format($order->planned_quantity_kg, 1) }} kg</td>
                                        <td>
                                            <span class="badge bg-{{ $order->status === 'in_progress' ? 'primary' : ($order->status === 'completed' ? 'success' : 'secondary') }}">
                                                {{ __('status.' . $order->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox me-1"></i>{{ __('dashboard.no_recent_orders') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Recent Breakdowns Tab --}}
                    <div class="tab-pane fade" id="breakdowns-pane" role="tabpanel"
                         aria-labelledby="breakdowns-tab">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>{{ __('dashboard.reported_at') }}</th>
                                        <th>{{ __('dashboard.machine') }}</th>
                                        <th>{{ __('dashboard.description') }}</th>
                                        <th>{{ __('dashboard.reported_by') }}</th>
                                        <th>{{ __('dashboard.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse(($recentBreakdowns ?? []) as $breakdown)
                                    <tr>
                                        <td>{{ $breakdown->reported_at?->format('d.m.Y H:i') }}</td>
                                        <td>{{ $breakdown->machine?->name }}</td>
                                        <td>{{ Str::limit($breakdown->description, 50) }}</td>
                                        <td>{{ $breakdown->reporter?->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $breakdown->status === 'open' ? 'danger' : ($breakdown->status === 'in_progress' ? 'warning' : 'success') }}">
                                                {{ __('status.' . $breakdown->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            <i class="bi bi-inbox me-1"></i>{{ __('dashboard.no_recent_breakdowns') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
