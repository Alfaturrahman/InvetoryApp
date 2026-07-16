<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index(Request $request)
    {
        $loans = Loan::with('item')
            ->where('user_id', $request->user()->id)
            ->latest('requested_at')
            ->paginate(12);

        return view('technician.loans.index', compact('loans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => ['required', 'exists:items,id'],
            'requested_qty' => ['required', 'integer', 'min:1'],
            'due_at' => ['required', 'date', 'after_or_equal:today'],
            'notes' => ['nullable', 'string'],
        ]);

        $item = Item::findOrFail($validated['item_id']);

        if ($item->status !== 'normal') {
            return back()->with('error', 'Alat tidak dalam kondisi normal untuk dipinjam.');
        }

        if ($item->stock < (int) $validated['requested_qty']) {
            return back()->with('error', 'Stok alat tidak cukup.');
        }

        Loan::create([
            'user_id' => $request->user()->id,
            'item_id' => $validated['item_id'],
            'requested_qty' => $validated['requested_qty'],
            'due_at' => $validated['due_at'],
            'status' => 'pending',
            'requested_at' => now(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return back()->with('success', 'Permintaan peminjaman berhasil dikirim ke admin.');
    }
}
