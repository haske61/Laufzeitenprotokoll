@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Production Logs') }}</h1>
        <a href="{{ route('production-logs.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('New Log') }}
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('Close') }}"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Production Order #') }}</th>
                            <th>{{ __('Machine') }}</th>
                            <th>{{ __('Started') }}</th>
                            <th>{{ __('Ended') }}</th>
                            <th>{{ __('Duration') }}</th>
                            <th>{{ __('Input Qty (kg)') }}</th>
                            <th>{{ __('Output Qty (kg)') }}</th>
                            <th>{{ __('Operator') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productionLogs as $log)
                            <tr>
                                <td>{{ $log->productionOrder->order_number ?? '-' }}</td>
                                <td>{{ $log->machine->name ?? '-' }}</td>
                                <td>{{ $log->started_at?->format('Y-m-d H:i') }}</td>
                                <td>{{ $log->ended_at?->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($log->started_at && $log->ended_at)
                                        {{ $log->started_at->diffForHumans($log->ended_at, true) }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $log->input_quantity_kg !== null ? number_format($log->input_quantity_kg, 2) : '-' }}</td>
                                <td>{{ $log->output_quantity_kg !== null ? number_format($log->output_quantity_kg, 2) : '-' }}</td>
                                <td>{{ $log->operator->name ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('production-logs.show', $log) }}" class="btn btn-outline-info" title="{{ __('View') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('production-logs.edit', $log) }}" class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('production-logs.destroy', $log) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this production log?') }}')">
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
                                <td colspan="9" class="text-center text-muted py-4">{{ __('No production logs found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($productionLogs->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $productionLogs->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
