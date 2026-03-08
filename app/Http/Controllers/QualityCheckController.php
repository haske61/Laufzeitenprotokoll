<?php

namespace App\Http\Controllers;

use App\Models\ProductionOrder;
use App\Models\QualityCheck;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class QualityCheckController extends Controller
{
    /**
     * Display a listing of all quality checks.
     */
    public function index(): View
    {
        $qualityChecks = QualityCheck::with(['productionOrder', 'checker'])
            ->latest('checked_at')
            ->paginate(20);

        return view('quality-checks.index', compact('qualityChecks'));
    }

    /**
     * Show the form for creating a new quality check.
     */
    public function create(): View
    {
        $productionOrders = ProductionOrder::orderByDesc('created_at')->get();

        return view('quality-checks.create', compact('productionOrders'));
    }

    /**
     * Store a newly created quality check in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'production_order_id' => ['required', 'exists:production_orders,id'],
            'checked_at' => ['required', 'date'],
            'moisture_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fat_content_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'particle_size_microns' => ['nullable', 'numeric', 'min:0'],
            'temperature' => ['nullable', 'numeric'],
            'viscosity' => ['nullable', 'numeric', 'min:0'],
            'ph_value' => ['nullable', 'numeric', 'min:0', 'max:14'],
            'passed' => ['required', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['checked_by'] = Auth::id();

        QualityCheck::create($validated);

        return redirect()
            ->route('quality-checks.index')
            ->with('success', __('Quality check successfully created.'));
    }

    /**
     * Display the specified quality check.
     */
    public function show(QualityCheck $qualityCheck): View
    {
        $qualityCheck->load(['productionOrder.beanDelivery', 'checker']);

        return view('quality-checks.show', compact('qualityCheck'));
    }

    /**
     * Show the form for editing the specified quality check.
     */
    public function edit(QualityCheck $qualityCheck): View
    {
        $productionOrders = ProductionOrder::orderByDesc('created_at')->get();

        return view('quality-checks.edit', compact('qualityCheck', 'productionOrders'));
    }

    /**
     * Update the specified quality check in storage.
     */
    public function update(Request $request, QualityCheck $qualityCheck): RedirectResponse
    {
        $validated = $request->validate([
            'production_order_id' => ['required', 'exists:production_orders,id'],
            'checked_at' => ['required', 'date'],
            'moisture_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fat_content_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'particle_size_microns' => ['nullable', 'numeric', 'min:0'],
            'temperature' => ['nullable', 'numeric'],
            'viscosity' => ['nullable', 'numeric', 'min:0'],
            'ph_value' => ['nullable', 'numeric', 'min:0', 'max:14'],
            'passed' => ['required', 'boolean'],
            'notes' => ['nullable', 'string'],
        ]);

        $qualityCheck->update($validated);

        return redirect()
            ->route('quality-checks.show', $qualityCheck)
            ->with('success', __('Quality check successfully updated.'));
    }

    /**
     * Remove the specified quality check from storage.
     */
    public function destroy(QualityCheck $qualityCheck): RedirectResponse
    {
        $qualityCheck->delete();

        return redirect()
            ->route('quality-checks.index')
            ->with('success', __('Quality check successfully deleted.'));
    }
}
