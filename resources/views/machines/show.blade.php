@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-cpu me-2"></i>{{ $machine->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.machines.edit', $machine) }}" class="btn btn-warning">
                <i class="bi bi-pencil me-1"></i>{{ __('Edit') }}
            </a>
            <a href="{{ route('admin.machines.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-1"></i>{{ __('Back') }}
            </a>
        </div>
    </div>

    {{-- Machine Details Card --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-info-circle me-1"></i> {{ __('Machine Details') }}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-muted" style="width: 40%;">{{ __('Name') }}</th>
                            <td>{{ $machine->name }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('Type') }}</th>
                            <td>{{ $machine->type ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('Location') }}</th>
                            <td>{{ $machine->location ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('Status') }}</th>
                            <td>
                                @if($machine->status === 'active')
                                    <span class="badge bg-success">{{ __('Active') }}</span>
                                @elseif($machine->status === 'inactive')
                                    <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                                @elseif($machine->status === 'maintenance')
                                    <span class="badge bg-warning text-dark">{{ __('Maintenance') }}</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th class="text-muted" style="width: 40%;">{{ __('Serial Number') }}</th>
                            <td>{{ $machine->serial_number ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('Purchase Date') }}</th>
                            <td>{{ $machine->purchase_date?->format('Y-m-d') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th class="text-muted">{{ __('Description') }}</th>
                            <td>{{ $machine->description ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase small fw-bold opacity-75">{{ __('Total Runtime') }}</div>
                        <div class="stat-value">{{ number_format($statistics['total_runtime_hours'] ?? 0, 1) }}h</div>
                    </div>
                    <i class="bi bi-clock-history stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-danger text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase small fw-bold opacity-75">{{ __('Total Breakdowns') }}</div>
                        <div class="stat-value">{{ $statistics['total_breakdowns'] ?? 0 }}</div>
                    </div>
                    <i class="bi bi-exclamation-triangle stat-icon"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card stat-card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-uppercase small fw-bold opacity-75">{{ __('Uptime') }}</div>
                        <div class="stat-value">{{ number_format($statistics['uptime_percentage'] ?? 0, 1) }}%</div>
                    </div>
                    <i class="bi bi-graph-up stat-icon"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Production Logs --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-journal-text me-1"></i> {{ __('Recent Production Logs') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Production Order') }}</th>
                            <th>{{ __('Operator') }}</th>
                            <th>{{ __('Start Time') }}</th>
                            <th>{{ __('End Time') }}</th>
                            <th>{{ __('Output (kg)') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentLogs as $log)
                            <tr>
                                <td>{{ $log->created_at?->format('Y-m-d') }}</td>
                                <td>{{ $log->productionOrder->order_number ?? '-' }}</td>
                                <td>{{ $log->operator->name ?? '-' }}</td>
                                <td>{{ $log->start_time }}</td>
                                <td>{{ $log->end_time }}</td>
                                <td>{{ number_format($log->output_kg ?? 0, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">{{ __('No production logs found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Breakdowns --}}
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-exclamation-triangle me-1"></i> {{ __('Recent Breakdowns') }}
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Reported By') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Severity') }}</th>
                            <th>{{ __('Duration (h)') }}</th>
                            <th>{{ __('Resolved') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentBreakdowns as $breakdown)
                            <tr>
                                <td>{{ $breakdown->created_at?->format('Y-m-d') }}</td>
                                <td>{{ $breakdown->reportedBy->name ?? '-' }}</td>
                                <td>{{ Str::limit($breakdown->description, 50) }}</td>
                                <td>
                                    @if($breakdown->severity === 'high')
                                        <span class="badge bg-danger">{{ __('High') }}</span>
                                    @elseif($breakdown->severity === 'medium')
                                        <span class="badge bg-warning text-dark">{{ __('Medium') }}</span>
                                    @else
                                        <span class="badge bg-info">{{ __('Low') }}</span>
                                    @endif
                                </td>
                                <td>{{ number_format($breakdown->duration_hours ?? 0, 1) }}</td>
                                <td>
                                    @if($breakdown->resolved_at)
                                        <span class="badge bg-success">{{ __('Yes') }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ __('No') }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">{{ __('No breakdowns found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
