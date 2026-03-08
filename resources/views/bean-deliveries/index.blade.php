@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('Bean Deliveries') }}</h1>
        <a href="{{ route('bean-deliveries.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> {{ __('New Delivery') }}
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
                            <th>{{ __('Batch #') }}</th>
                            <th>{{ __('Supplier') }}</th>
                            <th>{{ __('Origin') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Quantity (kg)') }}</th>
                            <th>{{ __('Moisture %') }}</th>
                            <th>{{ __('Quality Grade') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($beanDeliveries as $delivery)
                            <tr>
                                <td>{{ $delivery->batch_number }}</td>
                                <td>{{ $delivery->supplier_name }}</td>
                                <td>{{ $delivery->origin_country }}</td>
                                <td>{{ $delivery->delivery_date?->format('Y-m-d') }}</td>
                                <td>{{ number_format($delivery->quantity_kg, 2) }}</td>
                                <td>{{ number_format($delivery->moisture_percentage, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $delivery->quality_grade === 'A' ? 'success' : ($delivery->quality_grade === 'B' ? 'primary' : ($delivery->quality_grade === 'C' ? 'warning' : 'danger')) }}">
                                        {{ $delivery->quality_grade }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('bean-deliveries.show', $delivery) }}" class="btn btn-outline-info" title="{{ __('View') }}">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('bean-deliveries.edit', $delivery) }}" class="btn btn-outline-warning" title="{{ __('Edit') }}">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('bean-deliveries.destroy', $delivery) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Are you sure you want to delete this delivery?') }}')">
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
                                <td colspan="8" class="text-center text-muted py-4">{{ __('No bean deliveries found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($beanDeliveries->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $beanDeliveries->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
