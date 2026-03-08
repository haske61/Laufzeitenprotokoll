@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Machine Breakdowns') }}</h1>
        @auth
        @if(auth()->user()->isAdmin())
        <a href="{{ route('machine-breakdowns.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('Report Breakdown') }}
        </a>
        @endif
        @endauth
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('machine-breakdowns.index') }}" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="status" class="form-label">{{ __('Status') }}</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">{{ __('All') }}</option>
                        <option value="reported" {{ request('status') === 'reported' ? 'selected' : '' }}>{{ __('Reported') }}</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                        <option value="resolved" {{ request('status') === 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="machine_id" class="form-label">{{ __('Machine') }}</label>
                    <select name="machine_id" id="machine_id" class="form-select">
                        <option value="">{{ __('All Machines') }}</option>
                        @foreach($machines as $machine)
                            <option value="{{ $machine->id }}" {{ request('machine_id') == $machine->id ? 'selected' : '' }}>
                                {{ $machine->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-secondary">
                        <i class="bi bi-funnel"></i> {{ __('Filter') }}
                    </button>
                    <a href="{{ route('machine-breakdowns.index') }}" class="btn btn-outline-secondary">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Machine') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Severity') }}</th>
                            <th>{{ __('Started') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Reported By') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($breakdowns as $breakdown)
                            <tr>
                                <td>{{ $breakdown->machine->name }}</td>
                                <td>
                                    <span class="badge bg-secondary">{{ ucfirst($breakdown->type) }}</span>
                                </td>
                                <td>
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
                                </td>
                                <td>{{ $breakdown->started_at?->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($breakdown->ended_at)
                                        {{ $breakdown->started_at->diffForHumans($breakdown->ended_at, true) }}
                                    @else
                                        <span class="text-muted">{{ __('Ongoing') }}</span>
                                    @endif
                                </td>
                                <td>
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
                                </td>
                                <td>{{ $breakdown->reporter->name ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('machine-breakdowns.show', $breakdown) }}" class="btn btn-outline-info" title="{{ __('View') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @auth
                                        @if(auth()->user()->isAdmin())
                                        <a href="{{ route('machine-breakdowns.edit', $breakdown) }}" class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('machine-breakdowns.destroy', $breakdown) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this breakdown?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="{{ __('Delete') }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @endif
                                        @endauth
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">{{ __('No machine breakdowns found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($breakdowns->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $breakdowns->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
