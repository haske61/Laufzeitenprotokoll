@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Quality Check Details') }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('quality-checks.edit', $qualityCheck) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> {{ __('Edit') }}
            </a>
            <form action="{{ route('quality-checks.destroy', $qualityCheck) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this quality check?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> {{ __('Delete') }}
                </button>
            </form>
            <a href="{{ route('quality-checks.index') }}" class="btn btn-secondary">
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
                    <h5 class="mb-0">{{ __('General Information') }}</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Production Order') }}</dt>
                        <dd class="col-sm-7">
                            @if($qualityCheck->productionOrder)
                                <a href="{{ route('production-orders.show', $qualityCheck->productionOrder) }}">
                                    {{ $qualityCheck->productionOrder->order_number }}
                                </a>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </dd>

                        <dt class="col-sm-5">{{ __('Checked At') }}</dt>
                        <dd class="col-sm-7">{{ $qualityCheck->checked_at?->format('Y-m-d H:i') }}</dd>

                        <dt class="col-sm-5">{{ __('Checked By') }}</dt>
                        <dd class="col-sm-7">{{ $qualityCheck->checker->name ?? '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Result') }}</dt>
                        <dd class="col-sm-7">
                            @if($qualityCheck->passed)
                                <span class="badge bg-success fs-6">
                                    <i class="bi bi-check-circle"></i> {{ __('Passed') }}
                                </span>
                            @else
                                <span class="badge bg-danger fs-6">
                                    <i class="bi bi-x-circle"></i> {{ __('Failed') }}
                                </span>
                            @endif
                        </dd>
                    </dl>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">{{ __('Quality Parameters') }}</h5>
                </div>
                <div class="card-body">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Moisture') }}</dt>
                        <dd class="col-sm-7">{{ $qualityCheck->moisture_percentage !== null ? number_format($qualityCheck->moisture_percentage, 2) . ' %' : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Fat Content') }}</dt>
                        <dd class="col-sm-7">{{ $qualityCheck->fat_content_percentage !== null ? number_format($qualityCheck->fat_content_percentage, 2) . ' %' : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Particle Size') }}</dt>
                        <dd class="col-sm-7">{{ $qualityCheck->particle_size_microns !== null ? number_format($qualityCheck->particle_size_microns, 1) . ' µm' : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Temperature') }}</dt>
                        <dd class="col-sm-7">{{ $qualityCheck->temperature !== null ? $qualityCheck->temperature . ' °C' : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('Viscosity') }}</dt>
                        <dd class="col-sm-7">{{ $qualityCheck->viscosity !== null ? number_format($qualityCheck->viscosity, 2) : '-' }}</dd>

                        <dt class="col-sm-5">{{ __('pH Value') }}</dt>
                        <dd class="col-sm-7">{{ $qualityCheck->ph_value !== null ? number_format($qualityCheck->ph_value, 2) : '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    @if($qualityCheck->notes)
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Notes') }}</h5>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $qualityCheck->notes }}</p>
            </div>
        </div>
    @endif
</div>
@endsection
