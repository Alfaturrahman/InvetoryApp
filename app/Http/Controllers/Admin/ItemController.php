<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()
    {
        $items = Item::orderBy('name')->paginate(12);
        return view('admin.items.index', compact('items'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'max:30', 'unique:items,code'],
            'name' => ['required', 'max:255'],
            'category' => ['required', 'max:100'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:normal,rusak,servis'],
            'description' => ['nullable', 'string'],
        ]);

        Item::create($validated);

        return back()->with('success', 'Data alat berhasil ditambahkan.');
    }

    public function update(Request $request, Item $item)
    {
        $validated = $request->validate([
            'code' => ['required', 'max:30', 'unique:items,code,'.$item->id],
            'name' => ['required', 'max:255'],
            'category' => ['required', 'max:100'],
            'stock' => ['required', 'integer', 'min:0'],
            'status' => ['required', 'in:normal,rusak,servis'],
            'description' => ['nullable', 'string'],
        ]);

        $item->update($validated);

        return back()->with('success', 'Data alat berhasil diperbarui.');
    }

    public function destroy(Item $item)
    {
        if ($item->loans()->whereIn('status', ['pending', 'approved'])->exists()) {
            return back()->with('error', 'Alat tidak bisa dihapus karena masih dipinjam/proses.');
        }

        $item->delete();

        return back()->with('success', 'Data alat berhasil dihapus.');
    }
}
