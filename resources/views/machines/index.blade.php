@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-cpu me-2"></i>{{ __('Machines') }}</h1>
        <a href="{{ route('admin.machines.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('Add Machine') }}
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Location') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Serial Number') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($machines as $machine)
                            <tr>
                                <td>{{ $machine->name }}</td>
                                <td>{{ $machine->type }}</td>
                                <td>{{ $machine->location }}</td>
                                <td>
                                    @if($machine->status === 'active')
                                        <span class="badge bg-success">{{ __('Active') }}</span>
                                    @elseif($machine->status === 'inactive')
                                        <span class="badge bg-secondary">{{ __('Inactive') }}</span>
                                    @elseif($machine->status === 'maintenance')
                                        <span class="badge bg-warning text-dark">{{ __('Maintenance') }}</span>
                                    @endif
                                </td>
                                <td>{{ $machine->serial_number }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.machines.show', $machine) }}" class="btn btn-outline-info" title="{{ __('View') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.machines.edit', $machine) }}" class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.machines.destroy', $machine) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this machine?') }}')">
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
                                <td colspan="6" class="text-center text-muted py-4">{{ __('No machines found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($machines->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $machines->links() }}
                </div>
            @endif
        </div>
    </div>

    {{-- Soft-deleted machines --}}
    @if(isset($trashedMachines) && $trashedMachines->count() > 0)
        <div class="card mt-4">
            <div class="card-header bg-secondary text-white">
                <i class="bi bi-trash me-1"></i> {{ __('Deleted Machines') }}
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Location') }}</th>
                                <th>{{ __('Serial Number') }}</th>
                                <th>{{ __('Deleted At') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trashedMachines as $machine)
                                <tr>
                                    <td>{{ $machine->name }}</td>
                                    <td>{{ $machine->type }}</td>
                                    <td>{{ $machine->location }}</td>
                                    <td>{{ $machine->serial_number }}</td>
                                    <td>{{ $machine->deleted_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <form action="{{ route('admin.machines.restore', $machine->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to restore this machine?') }}')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-outline-success" title="{{ __('Restore') }}">
                                                <i class="bi bi-arrow-counterclockwise"></i> {{ __('Restore') }}
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
