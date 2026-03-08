@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Production Log Details') }}</h1>
        <div class="d-flex gap-2">
            @auth
            @if(auth()->user()->isAdmin())
            <a href="{{ route('production-logs.edit', $productionLog) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> {{ __('Edit') }}
            </a>
            <form action="{{ route('production-logs.destroy', $productionLog) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this production log?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> {{ __('Delete') }}
                </button>
            </form>
            @endif
            @endauth
            <a href="{{ route('production-logs.index') }}" class="btn btn-secondary">
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

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Order & Machine') }}</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Production Order') }}</dt>
                        <dd class="col-sm-7">
                            @if($productionLog->productionOrder)
                                <a href="{{ route('production-orders.show', $productionLog->productionOrder) }}">
                                    {{ $productionLog->productionOrder->order_number }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">{{ __('Machine') }}</dt>
                        <dd class="col-sm-7">{{ $productionLog->machine->name ?? '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Operator') }}</dt>
                        <dd class="col-sm-7">{{ $productionLog->operator->name ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Time & Duration') }}</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Started At') }}</dt>
                        <dd class="col-sm-7">{{ $productionLog->started_at?->format('Y-m-d H:i') }}</dd>

                        <dt class="col-sm-5">{{ __('Ended At') }}</dt>
                        <dd class="col-sm-7">{{ $productionLog->ended_at?->format('Y-m-d H:i') ?? '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Duration') }}</dt>
                        <dd class="col-sm-7">
                            @if($productionLog->started_at && $productionLog->ended_at)
                                {{ $productionLog->started_at->diffForHumans($productionLog->ended_at, true) }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Quantities') }}</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Input Quantity') }}</dt>
                        <dd class="col-sm-7">{{ $productionLog->input_quantity_kg !== null ? number_format($productionLog->input_quantity_kg, 2) . ' kg' : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Output Quantity') }}</dt>
                        <dd class="col-sm-7">{{ $productionLog->output_quantity_kg !== null ? number_format($productionLog->output_quantity_kg, 2) . ' kg' : '-' }}</dd>

                        @if($productionLog->input_quantity_kg && $productionLog->output_quantity_kg)
                            <dt class="col-sm-5">{{ __('Yield') }}</dt>
                            <dd class="col-sm-7">{{ number_format(($productionLog->output_quantity_kg / $productionLog->input_quantity_kg) * 100, 1) }}%</dd>
                        @endif
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Environment') }}</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Temperature') }}</dt>
                        <dd class="col-sm-7">{{ $productionLog->temperature !== null ? $productionLog->temperature . ' °C' : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Humidity') }}</dt>
                        <dd class="col-sm-7">{{ $productionLog->humidity !== null ? $productionLog->humidity . ' %' : '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    @if($productionLog->notes)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Notes') }}</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $productionLog->notes }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
