<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class TechnicianController extends Controller
{
    public function index()
    {
        $technicians = User::where('role', 'teknisi')->orderBy('name')->paginate(12);
        return view('admin.technicians.index', compact('technicians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'teknisi',
            'is_active' => true,
        ]);

        return back()->with('success', 'Akun teknisi berhasil ditambahkan.');
    }

    public function update(Request $request, User $technician)
    {
        if ($technician->role !== 'teknisi') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($technician->id)],
            'is_active' => ['nullable', 'boolean'],
            'password' => ['nullable', 'min:6'],
        ]);

        $technician->name = $validated['name'];
        $technician->email = $validated['email'];
        $technician->is_active = (bool) ($validated['is_active'] ?? false);

        if (! empty($validated['password'])) {
            $technician->password = Hash::make($validated['password']);
        }

        $technician->save();

        return back()->with('success', 'Data teknisi berhasil diperbarui.');
    }

    public function destroy(User $technician)
    {
        if ($technician->role !== 'teknisi') {
            abort(404);
        }

        if ($technician->loans()->whereIn('status', ['pending', 'approved'])->exists()) {
            return back()->with('error', 'Teknisi masih memiliki peminjaman aktif.');
        }

        $technician->delete();

        return back()->with('success', 'Akun teknisi berhasil dihapus.');
    }
}
