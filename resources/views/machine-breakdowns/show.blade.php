@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Breakdown Details') }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('machine-breakdowns.edit', $breakdown) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> {{ __('Edit') }}
            </a>
            <form action="{{ route('machine-breakdowns.destroy', $breakdown) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this breakdown?') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash"></i> {{ __('Delete') }}
                </button>
            </form>
            <a href="{{ route('machine-breakdowns.index') }}" class="btn btn-secondary">
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

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="text-muted mb-3">{{ __('Machine Information') }}</h5>
                    <dl class="row mb-0">
                        <dt class="col-sm-4">{{ __('Machine') }}</dt>
                        <dd class="col-sm-8">{{ $breakdown->machine->name }}</dd>

                        <dt class="col-sm-4">{{ __('Type') }}</dt>
                        <dd class="col-sm-8">
                            <span class="badge bg-secondary">{{ ucfirst($breakdown->type) }}</span>
                        </dd>

                        <dt class="col-sm-4">{{ __('Severity') }}</dt>
                        <dd class="col-sm-8">
                            @switch($breakdown->severity)
                                @case('low')
                                    <span class="badge bg-info">{{ __('Low') }}</span>
                                    @break
                                @case('medium')
                                    <span class="badge bg-warning text-dark">{{ __('Medium') }}</span>
                                    @break
                                @case('high')
                                    <span class="badge" style="background-color: #fd7e14;">{{ __('High') }}</span>
                                    @break
                                @case('critical')
                                    <span class="badge bg-danger">{{ __('Critical') }}</span>
                                    @break
                            @endswitch
                        </dd>

                        <dt class="col-sm-4">{{ __('Status') }}</dt>
                        <dd class="col-sm-8">
                            @switch($breakdown->status)
                                @case('reported')
                                    <span class="badge bg-warning text-dark">{{ __('Reported') }}</span>
                                    @break
                                @case('in_progress')
                                    <span class="badge bg-primary">{{ __('In Progress') }}</span>
                                    @break
                                @case('resolved')
                                    <span class="badge bg-success">{{ __('Resolved') }}</span>
                                    @break
                            @endswitch
                        </dd>
                    </dl>
                </div>

                <div class="col-md-6">
                    <h5 class="text-muted mb-3">{{ __('Timeline') }}</h5>
                    <div class="position-relative ps-4 border-start border-2">
                        <div class="mb-3">
                            <div class="position-absolute start-0 translate-middle-x bg-warning rounded-circle" style="width: 12px; height: 12px; top: 4px;"></div>
                            <strong>{{ __('Started') }}</strong><br>
                            <span>{{ $breakdown->started_at?->format('Y-m-d H:i') }}</span>
                        </div>

                        @if($breakdown->ended_at)
                            <div class="mb-3">
                                <div class="position-absolute start-0 translate-middle-x bg-success rounded-circle" style="width: 12px; height: 12px;"></div>
                                <strong>{{ __('Ended') }}</strong><br>
                                <span>{{ $breakdown->ended_at->format('Y-m-d H:i') }}</span>
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('Duration') }}</strong><br>
                                <span>{{ $breakdown->started_at->diffForHumans($breakdown->ended_at, true) }}</span>
                            </div>
                        @else
                            <div class="mb-3">
                                <div class="position-absolute start-0 translate-middle-x bg-danger rounded-circle" style="width: 12px; height: 12px;"></div>
                                <strong>{{ __('Status') }}</strong><br>
                                <span class="text-danger">{{ __('Ongoing') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <hr>

            <div class="row mb-4">
                <div class="col-md-12">
                    <h5 class="text-muted mb-3">{{ __('Description') }}</h5>
                    <p>{{ $breakdown->description }}</p>
                </div>
            </div>

            @if($breakdown->cause)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-muted mb-3">{{ __('Cause') }}</h5>
                        <p>{{ $breakdown->cause }}</p>
                    </div>
                </div>
            @endif

            @if($breakdown->resolution)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-muted mb-3">{{ __('Resolution') }}</h5>
                        <p>{{ $breakdown->resolution }}</p>
                    </div>
                </div>
            @endif

            @if($breakdown->parts_replaced)
                <div class="row mb-4">
                    <div class="col-md-12">
                        <h5 class="text-muted mb-3">{{ __('Parts Replaced') }}</h5>
                        <p>{{ $breakdown->parts_replaced }}</p>
                    </div>
                </div>
            @endif

            <hr>

            <div class="row">
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Reported By') }}</dt>
                        <dd class="col-sm-7">{{ $breakdown->reporter->name ?? '-' }}</dd>
                    </dl>
                </div>
                <div class="col-md-6">
                    <dl class="row mb-0">
                        <dt class="col-sm-5">{{ __('Resolved By') }}</dt>
                        <dd class="col-sm-7">{{ $breakdown->resolver->name ?? '-' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
