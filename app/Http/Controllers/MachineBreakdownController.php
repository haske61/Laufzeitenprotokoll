<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\MachineBreakdown;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class MachineBreakdownController extends Controller
{
    /**
     * Display a listing of all machine breakdowns with optional filters.
     */
    public function index(Request $request): View
    {
        $query = MachineBreakdown::with(['machine', 'reporter', 'resolver']);

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        if ($request->filled('machine_id')) {
            $query->where('machine_id', $request->input('machine_id'));
        }

        $breakdowns = $query->latest('started_at')->paginate(20);
        $machines = Machine::orderBy('name')->get();

        return view('machine-breakdowns.index', compact('breakdowns', 'machines'));
    }

    /**
     * Show the form for creating a new machine breakdown.
     */
    public function create(): View
    {
        $machines = Machine::orderBy('name')->get();

        return view('machine-breakdowns.create', compact('machines'));
    }

    /**
     * Store a newly created machine breakdown in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'machine_id' => ['required', 'exists:machines,id'],
            'type' => ['required', 'string', 'max:255'],
            'severity' => ['required', 'string', 'max:255'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'description' => ['required', 'string'],
            'cause' => ['nullable', 'string'],
            'resolution' => ['nullable', 'string'],
            'parts_replaced' => ['nullable', 'string'],
            'status' => ['nullable', 'string', 'in:reported,in_progress,resolved'],
        ]);

        $validated['reported_by'] = Auth::id();
        $validated['status'] = $validated['status'] ?? 'reported';

        MachineBreakdown::create($validated);

        return redirect()
            ->route('machine-breakdowns.index')
            ->with('success', __('Machine breakdown successfully reported.'));
    }

    /**
     * Display the specified machine breakdown.
     */
    public function show(MachineBreakdown $machineBreakdown): View
    {
        $machineBreakdown->load(['machine', 'reporter', 'resolver']);

        return view('machine-breakdowns.show', ['breakdown' => $machineBreakdown]);
    }

    /**
     * Show the form for editing the specified machine breakdown.
     */
    public function edit(MachineBreakdown $machineBreakdown): View
    {
        $machines = Machine::orderBy('name')->get();

        return view('machine-breakdowns.edit', ['breakdown' => $machineBreakdown, 'machines' => $machines]);
    }

    /**
     * Update the specified machine breakdown in storage.
     */
    public function update(Request $request, MachineBreakdown $machineBreakdown): RedirectResponse
    {
        $validated = $request->validate([
            'machine_id' => ['required', 'exists:machines,id'],
            'type' => ['required', 'string', 'max:255'],
            'severity' => ['required', 'string', 'max:255'],
            'started_at' => ['required', 'date'],
            'ended_at' => ['nullable', 'date', 'after_or_equal:started_at'],
            'description' => ['required', 'string'],
            'cause' => ['nullable', 'string'],
            'resolution' => ['nullable', 'string'],
            'parts_replaced' => ['nullable', 'string'],
            'status' => ['required', 'string', 'in:reported,in_progress,resolved'],
        ]);

        $previousStatus = $machineBreakdown->status;

        if ($validated['status'] === 'resolved' && $previousStatus !== 'resolved') {
            $validated['resolved_by'] = Auth::id();

            if (isset($validated['ended_at'])) {
                $startedAt = \Carbon\Carbon::parse($validated['started_at']);
                $endedAt = \Carbon\Carbon::parse($validated['ended_at']);
                $validated['duration_minutes'] = $startedAt->diffInMinutes($endedAt);
            } elseif ($machineBreakdown->started_at) {
                $validated['ended_at'] = now();
                $validated['duration_minutes'] = $machineBreakdown->started_at->diffInMinutes(now());
            }
        }

        $machineBreakdown->update($validated);

        return redirect()
            ->route('machine-breakdowns.show', $machineBreakdown)
            ->with('success', __('Machine breakdown successfully updated.'));
    }

    /**
     * Remove the specified machine breakdown from storage.
     */
    public function destroy(MachineBreakdown $machineBreakdown): RedirectResponse
    {
        $machineBreakdown->delete();

        return redirect()
            ->route('machine-breakdowns.index')
            ->with('success', __('Machine breakdown successfully deleted.'));
    }
}
