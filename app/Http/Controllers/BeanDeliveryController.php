<?php

namespace App\Http\Controllers;

use App\Models\BeanDelivery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BeanDeliveryController extends Controller
{
    /**
     * Display a listing of all bean deliveries ordered by delivery date descending.
     */
    public function index(): View
    {
        $deliveries = BeanDelivery::with('user')
            ->orderByDesc('delivery_date')
            ->paginate(20);

        return view('bean-deliveries.index', compact('deliveries'));
    }

    /**
     * Show the form for creating a new bean delivery.
     */
    public function create(): View
    {
        return view('bean-deliveries.create');
    }

    /**
     * Store a newly created bean delivery in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'supplier_name' => ['required', 'string', 'max:255'],
            'origin_country' => ['nullable', 'string', 'max:255'],
            'bean_type' => ['nullable', 'string', 'max:255'],
            'batch_number' => ['required', 'string', 'max:255', 'unique:bean_deliveries,batch_number'],
            'delivery_date' => ['required', 'date'],
            'quantity_kg' => ['required', 'numeric', 'min:0'],
            'moisture_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fat_content_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'quality_grade' => ['nullable', 'string', 'max:255'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $validated['user_id'] = Auth::id();

        BeanDelivery::create($validated);

        return redirect()
            ->route('bean-deliveries.index')
            ->with('success', __('Bean delivery successfully created.'));
    }

    /**
     * Display the specified bean delivery with linked production orders.
     */
    public function show(BeanDelivery $beanDelivery): View
    {
        $beanDelivery->load([
            'user',
            'productionOrders' => fn ($query) => $query->with('user')->latest(),
        ]);

        return view('bean-deliveries.show', compact('beanDelivery'));
    }

    /**
     * Show the form for editing the specified bean delivery.
     */
    public function edit(BeanDelivery $beanDelivery): View
    {
        return view('bean-deliveries.edit', compact('beanDelivery'));
    }

    /**
     * Update the specified bean delivery in storage.
     */
    public function update(Request $request, BeanDelivery $beanDelivery): RedirectResponse
    {
        $validated = $request->validate([
            'supplier_name' => ['required', 'string', 'max:255'],
            'origin_country' => ['nullable', 'string', 'max:255'],
            'bean_type' => ['nullable', 'string', 'max:255'],
            'batch_number' => ['required', 'string', 'max:255', "unique:bean_deliveries,batch_number,{$beanDelivery->id}"],
            'delivery_date' => ['required', 'date'],
            'quantity_kg' => ['required', 'numeric', 'min:0'],
            'moisture_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'fat_content_percentage' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'quality_grade' => ['nullable', 'string', 'max:255'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'notes' => ['nullable', 'string'],
        ]);

        $beanDelivery->update($validated);

        return redirect()
            ->route('bean-deliveries.show', $beanDelivery)
            ->with('success', __('Bean delivery successfully updated.'));
    }

    /**
     * Remove the specified bean delivery from storage.
     */
    public function destroy(BeanDelivery $beanDelivery): RedirectResponse
    {
        $beanDelivery->delete();

        return redirect()
            ->route('bean-deliveries.index')
            ->with('success', __('Bean delivery successfully deleted.'));
    }
}
