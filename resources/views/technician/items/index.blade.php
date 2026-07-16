@extends('layouts.app')

@section('content')
<div class="panel">
    <h2 style="margin-top:0;">Data Alat (Teknisi)</h2>
    <form method="GET" class="form-grid">
        <label style="grid-column: span 2;">Cari Alat
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama, kode, kategori">
        </label>
        <x-ui.button type="submit">Cari</x-ui.button>
        <x-ui.button :href="route('teknisi.items.index')">Reset</x-ui.button>
    </form>
</div>

<div class="panel table-wrap">
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Pinjam</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td data-label="Kode">{{ $item->code }}</td>
                    <td data-label="Nama">{{ $item->name }}</td>
                    <td data-label="Kategori">{{ $item->category }}</td>
                    <td data-label="Stok">{{ $item->stock }}</td>
                    <td data-label="Status">
                        <span class="badge {{ $item->status === 'normal' ? 'ok' : ($item->status === 'servis' ? 'warn' : 'bad') }}">
                            {{ strtoupper($item->status) }}
                        </span>
                    </td>
                    <td data-label="Pinjam">
                        <form action="{{ route('teknisi.loans.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="item_id" value="{{ $item->id }}">
                            <input type="number" name="requested_qty" min="1" max="{{ max(1, $item->stock) }}" value="1" required>
                            <input type="date" name="due_at" value="{{ now()->addDays(3)->toDateString() }}" required>
                            <input type="text" name="notes" placeholder="Catatan (opsional)">
                            <x-ui.button type="submit" variant="primary" :disabled="$item->stock < 1 || $item->status !== 'normal'">Ajukan</x-ui.button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Data alat kosong.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="panel">{{ $items->links() }}</div>
@endsection
