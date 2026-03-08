<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\ProductionLog;
use App\Models\ProductionOrder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductionLogController extends Controller
{
    /**
     * Display a listing of all production logs with related data.
     */
    public function index(): View
    {
        $logs = ProductionLog::with(['productionOrder', 'machine', 'user'])
            ->latest('started_at')
            ->paginate(20);

        return view('production-logs.index', compact('logs'));
    }

    /**
     * Show the form for creating a new production log.
     */
    public function create(): View
    {
        $productionOrders = ProductionOrder::orderByDesc('created_at')->get();
        $machines = Machine::where('status', 'active')->orderBy('name')->get();

        return view('production-logs.create', compact('productionOrders', 'machines'));
    }

    /**
     * Store a newly created production log in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'production_order_id' => ['required', 'exists:production_orders,id'],
            'machine_id' => ['required', 'exists:machines,id'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'input_quantity_kg' => ['nullable', 'numeric', 'min:0'],
            'output_quantity_kg' => ['nullable', 'numeric', 'min:0'],
            'temperature' => ['nullable', 'numeric'],
            'humidity' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();

        ProductionLog::create($validated);

        return redirect()
            ->route('production-logs.index')
            ->with('success', __('Production log successfully created.'));
    }

    /**
     * Display the specified production log.
     */
    public function show(ProductionLog $productionLog): View
    {
        $productionLog->load(['productionOrder.beanDelivery', 'machine', 'user']);

        return view('production-logs.show', compact('productionLog'));
    }

    /**
     * Show the form for editing the specified production log.
     */
    public function edit(ProductionLog $productionLog): View
    {
        $productionOrders = ProductionOrder::orderByDesc('created_at')->get();
        $machines = Machine::orderBy('name')->get();

        return view('production-logs.edit', compact('productionLog', 'productionOrders', 'machines'));
    }

    /**
     * Update the specified production log in storage.
     */
    public function update(Request $request, ProductionLog $productionLog): RedirectResponse
    {
        $validated = $request->validate([
            'production_order_id' => ['required', 'exists:production_orders,id'],
            'machine_id' => ['required', 'exists:machines,id'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'input_quantity_kg' => ['nullable', 'numeric', 'min:0'],
            'output_quantity_kg' => ['nullable', 'numeric', 'min:0'],
            'temperature' => ['nullable', 'numeric'],
            'humidity' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'notes' => ['nullable', 'string'],
        ]);

        $productionLog->update($validated);

        return redirect()
            ->route('production-logs.show', $productionLog)
            ->with('success', __('Production log successfully updated.'));
    }

    /**
     * Remove the specified production log from storage.
     */
    public function destroy(ProductionLog $productionLog): RedirectResponse
    {
        $productionLog->delete();

        return redirect()
            ->route('production-logs.index')
            ->with('success', __('Production log successfully deleted.'));
    }
}
