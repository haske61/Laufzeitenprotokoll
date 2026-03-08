<?php

namespace App\Http\Controllers;

use App\Models\BeanDelivery;
use App\Models\ProductionOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProductionOrderController extends Controller
{
    /**
     * Display a listing of all production orders with optional filters.
     */
    public function index(Request $request): View
    {
        $query = ProductionOrder::with(['user', 'beanDelivery']);

        if ($request->filled('type')) {
            $query->where('type', $request->input('type'));
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $orders = $query->latest()->paginate(20);

        return view('production-orders.index', compact('orders'));
    }

    /**
     * Display a listing of production orders filtered by type.
     */
    public function indexByType(string $type): View
    {
        abort_unless(in_array($type, ['nibs', 'mass']), 404);

        $orders = ProductionOrder::with(['user', 'beanDelivery'])
            ->where('type', $type)
            ->latest()
            ->paginate(20);

        return view('production-orders.index', compact('orders', 'type'));
    }

    /**
     * Show the form for creating a new production order.
     */
    public function create(): View
    {
        $beanDeliveries = BeanDelivery::orderByDesc('delivery_date')->get();

        return view('production-orders.create', compact('beanDeliveries'));
    }

    /**
     * Store a newly created production order in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'order_number' => ['nullable', 'string', 'max:255', 'unique:production_orders,order_number'],
            'type' => ['required', 'string', 'in:nibs,mass'],
            'status' => ['nullable', 'string', 'max:255'],
            'bean_delivery_id' => ['nullable', 'exists:bean_deliveries,id'],
            'batch_number' => ['required', 'string', 'max:255'],
            'target_quantity_kg' => ['required', 'numeric', 'min:0'],
            'actual_quantity_kg' => ['nullable', 'numeric', 'min:0'],
            'planned_start' => ['nullable', 'date'],
            'planned_end' => ['nullable', 'date', 'after_or_equal:planned_start'],
            'actual_start' => ['nullable', 'date'],
            'actual_end' => ['nullable', 'date', 'after_or_equal:actual_start'],
            'operator_name' => ['nullable', 'string', 'max:255'],
            'shift' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        if (empty($validated['order_number'])) {
            $prefix = strtoupper($validated['type'] === 'nibs' ? 'NIB' : 'MAS');
            $validated['order_number'] = $prefix . '-' . now()->format('Ymd') . '-' . strtoupper(Str::random(4));
        }

        $validated['user_id'] = Auth::id();

        ProductionOrder::create($validated);

        return redirect()
            ->route('production-orders.index')
            ->with('success', __('Production order successfully created.'));
    }

    /**
     * Display the specified production order with logs and quality checks.
     */
    public function show(ProductionOrder $productionOrder): View
    {
        $productionOrder->load([
            'user',
            'beanDelivery',
            'productionLogs' => fn ($query) => $query->with(['machine', 'user'])->latest('started_at'),
            'qualityChecks' => fn ($query) => $query->with('checker')->latest('checked_at'),
        ]);

        return view('production-orders.show', compact('productionOrder'));
    }

    /**
     * Show the form for editing the specified production order.
     */
    public function edit(ProductionOrder $productionOrder): View
    {
        $beanDeliveries = BeanDelivery::orderByDesc('delivery_date')->get();

        return view('production-orders.edit', compact('productionOrder', 'beanDeliveries'));
    }

    /**
     * Update the specified production order in storage.
     */
    public function update(Request $request, ProductionOrder $productionOrder): RedirectResponse
    {
        $validated = $request->validate([
            'order_number' => ['required', 'string', 'max:255', "unique:production_orders,order_number,{$productionOrder->id}"],
            'type' => ['required', 'string', 'in:nibs,mass'],
            'status' => ['nullable', 'string', 'max:255'],
            'bean_delivery_id' => ['nullable', 'exists:bean_deliveries,id'],
            'batch_number' => ['required', 'string', 'max:255'],
            'target_quantity_kg' => ['required', 'numeric', 'min:0'],
            'actual_quantity_kg' => ['nullable', 'numeric', 'min:0'],
            'planned_start' => ['nullable', 'date'],
            'planned_end' => ['nullable', 'date', 'after_or_equal:planned_start'],
            'actual_start' => ['nullable', 'date'],
            'actual_end' => ['nullable', 'date', 'after_or_equal:actual_start'],
            'operator_name' => ['nullable', 'string', 'max:255'],
            'shift' => ['nullable', 'string', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        if (isset($validated['actual_quantity_kg']) && $validated['actual_quantity_kg'] > 0 && $validated['target_quantity_kg'] > 0) {
            $validated['yield_percentage'] = round(($validated['actual_quantity_kg'] / $validated['target_quantity_kg']) * 100, 2);
        }

        $productionOrder->update($validated);

        return redirect()
            ->route('production-orders.show', $productionOrder)
            ->with('success', __('Production order successfully updated.'));
    }

    /**
     * Remove the specified production order from storage.
     */
    public function destroy(ProductionOrder $productionOrder): RedirectResponse
    {
        $productionOrder->delete();

        return redirect()
            ->route('production-orders.index')
            ->with('success', __('Production order successfully deleted.'));
    }
}
