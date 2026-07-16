<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::with('item')
            ->latest('maintenance_date')
            ->paginate(12);
        $items = Item::orderBy('name')->get();

        return view('admin.maintenances.index', compact('maintenances', 'items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'maintenance_date' => ['required', 'date'],
            'type' => ['required', 'in:preventive,corrective'],
            'condition_after' => ['required', 'in:normal,rusak,servis'],
            'notes' => ['nullable', 'string'],
        ]);

        Maintenance::create($validated);

        Item::where('id', $validated['item_id'])
            ->update(['status' => $validated['condition_after']]);

        return back()->with('success', 'Jadwal/riwayat maintenance berhasil disimpan.');
    }

    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
        return back()->with('success', 'Data maintenance berhasil dihapus.');
    }
}
