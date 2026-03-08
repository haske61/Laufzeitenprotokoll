<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MachineController extends Controller
{
    /**
     * Display a listing of all machines.
     */
    public function index(Request $request): View
    {
        $query = Machine::query();

        if ($request->boolean('with_trashed')) {
            $query->withTrashed();
        }

        $machines = $query->latest()->paginate(20);

        return view('machines.index', compact('machines'));
    }

    /**
     * Show the form for creating a new machine.
     */
    public function create(): View
    {
        return view('machines.create');
    }

    /**
     * Store a newly created machine in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:active,inactive,maintenance'],
            'purchase_date' => ['nullable', 'date'],
            'serial_number' => ['nullable', 'string', 'max:255', 'unique:machines,serial_number'],
        ]);

        Machine::create($validated);

        return redirect()
            ->route('admin.machines.index')
            ->with('success', __('Machine successfully created.'));
    }

    /**
     * Display the specified machine with its production logs and breakdowns.
     */
    public function show(Machine $machine): View
    {
        $machine->load([
            'productionLogs' => fn ($query) => $query->with(['productionOrder', 'user'])->latest('started_at'),
            'machineBreakdowns' => fn ($query) => $query->with(['reporter', 'resolver'])->latest('started_at'),
        ]);

        return view('machines.show', compact('machine'));
    }

    /**
     * Show the form for editing the specified machine.
     */
    public function edit(Machine $machine): View
    {
        return view('machines.edit', compact('machine'));
    }

    /**
     * Update the specified machine in storage.
     */
    public function update(Request $request, Machine $machine): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:active,inactive,maintenance'],
            'purchase_date' => ['nullable', 'date'],
            'serial_number' => ['nullable', 'string', 'max:255', "unique:machines,serial_number,{$machine->id}"],
        ]);

        $machine->update($validated);

        return redirect()
            ->route('admin.machines.show', $machine)
            ->with('success', __('Machine successfully updated.'));
    }

    /**
     * Soft delete the specified machine.
     */
    public function destroy(Machine $machine): RedirectResponse
    {
        $machine->delete();

        return redirect()
            ->route('admin.machines.index')
            ->with('success', __('Machine successfully deleted.'));
    }

    /**
     * Restore a soft-deleted machine.
     */
    public function restore(Machine $machine): RedirectResponse
    {
        $machine->restore();

        return redirect()
            ->route('admin.machines.index')
            ->with('success', __('Machine successfully restored.'));
    }
}
