@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Quality Checks') }}</h1>
        @auth
        @if(auth()->user()->isAdmin())
        <a href="{{ route('quality-checks.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('New Check') }}
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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th>{{ __('Production Order #') }}</th>
                            <th>{{ __('Checked At') }}</th>
                            <th>{{ __('Moisture %') }}</th>
                            <th>{{ __('Fat %') }}</th>
                            <th>{{ __('Particle Size') }}</th>
                            <th>{{ __('pH') }}</th>
                            <th>{{ __('Passed') }}</th>
                            <th>{{ __('Checked By') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($qualityChecks as $check)
                            <tr>
                                <td>{{ $check->productionOrder->order_number ?? '-' }}</td>
                                <td>{{ $check->checked_at?->format('Y-m-d H:i') }}</td>
                                <td>{{ $check->moisture_percentage !== null ? number_format($check->moisture_percentage, 2) : '-' }}</td>
                                <td>{{ $check->fat_content_percentage !== null ? number_format($check->fat_content_percentage, 2) : '-' }}</td>
                                <td>{{ $check->particle_size_microns !== null ? number_format($check->particle_size_microns, 1) . ' µm' : '-' }}</td>
                                <td>{{ $check->ph_value !== null ? number_format($check->ph_value, 2) : '-' }}</td>
                                <td>
                                    @if($check->passed)
                                        <i class="bi bi-check-circle-fill text-success fs-5"></i>
                                    @else
                                        <i class="bi bi-x-circle-fill text-danger fs-5"></i>
                                    @endif
                                </td>
                                <td>{{ $check->checker->name ?? '-' }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('quality-checks.show', $check) }}" class="btn btn-outline-info" title="{{ __('View') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @auth
                                        @if(auth()->user()->isAdmin())
                                        <a href="{{ route('quality-checks.edit', $check) }}" class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('quality-checks.destroy', $check) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this quality check?') }}')">
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
                                <td colspan="9" class="text-center text-muted py-4">{{ __('No quality checks found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($qualityChecks->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $qualityChecks->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
