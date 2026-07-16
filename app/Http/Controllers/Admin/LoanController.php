<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use App\Models\Maintenance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoanController extends Controller
{
    public function index()
    {
        $loans = Loan::with(['user', 'item'])
            ->latest('requested_at')
            ->paginate(15);

        return view('admin.loans.index', compact('loans'));
    }

    public function approve(Request $request, Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'approved_qty' => ['required', 'integer', 'min:1'],
            'due_at' => ['required', 'date', 'after_or_equal:today'],
        ]);

        $item = Item::findOrFail($loan->item_id);

        if ($validated['approved_qty'] > $item->stock) {
            return back()->with('error', 'Stok tidak mencukupi untuk disetujui.');
        }

        DB::transaction(function () use ($loan, $item, $validated): void {
            $item->decrement('stock', $validated['approved_qty']);

            $loan->update([
                'approved_qty' => $validated['approved_qty'],
                'due_at' => $validated['due_at'],
                'approved_at' => now(),
                'status' => 'approved',
            ]);
        });

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Request $request, Loan $loan)
    {
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Peminjaman ini sudah diproses sebelumnya.');
        }

        $validated = $request->validate([
            'notes' => ['nullable', 'string'],
        ]);

        $loan->update([
            'status' => 'rejected',
            'notes' => $validated['notes'] ?? $loan->notes,
        ]);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function returnLoan(Request $request, Loan $loan)
    {
        if ($loan->status !== 'approved') {
            return back()->with('error', 'Hanya peminjaman yang disetujui yang bisa dikembalikan.');
        }

        $validated = $request->validate([
            'condition_on_return' => ['required', 'in:normal,rusak,servis'],
            'notes' => ['nullable', 'string'],
        ]);

        DB::transaction(function () use ($loan, $validated): void {
            $item = Item::findOrFail($loan->item_id);

            $item->increment('stock', (int) ($loan->approved_qty ?? $loan->requested_qty));
            $item->status = $validated['condition_on_return'];
            $item->save();

            $loan->update([
                'status' => 'returned',
                'condition_on_return' => $validated['condition_on_return'],
                'returned_at' => now(),
                'notes' => $validated['notes'] ?? $loan->notes,
            ]);

            if ($validated['condition_on_return'] !== 'normal') {
                Maintenance::create([
                    'item_id' => $item->id,
                    'loan_id' => $loan->id,
                    'maintenance_date' => now()->toDateString(),
                    'type' => 'corrective',
                    'condition_after' => $validated['condition_on_return'],
                    'notes' => 'Auto-generated from return process. '.($validated['notes'] ?? ''),
                ]);
            }
        });

        return back()->with('success', 'Pengembalian alat berhasil dicatat.');
    }
}
