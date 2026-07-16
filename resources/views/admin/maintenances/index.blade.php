@extends('layouts.app')

@section('content')
<div class="panel">
    <h2 style="margin-top:0;">Maintenance Alat</h2>
    <form action="{{ route('admin.maintenances.store') }}" method="POST" class="form-grid">
        @csrf
        <label>Item
            <select name="item_id" required>
                <option value="">-- pilih alat --</option>
                @foreach($items as $item)
                    <option value="{{ $item->id }}">{{ $item->code }} - {{ $item->name }}</option>
                @endforeach
            </select>
        </label>
        <label>Tanggal
            <input type="date" name="maintenance_date" value="{{ now()->toDateString() }}" required>
        </label>
        <label>Jenis
            <select name="type" required>
                <option value="preventive">Preventive</option>
                <option value="corrective">Corrective</option>
            </select>
        </label>
        <label>Kondisi Setelah
            <select name="condition_after" required>
                <option value="normal">Normal</option>
                <option value="servis">Servis</option>
                <option value="rusak">Rusak</option>
            </select>
        </label>
        <label style="grid-column: span 2;">Catatan
            <input type="text" name="notes" placeholder="Opsional">
        </label>
        <x-ui.button type="submit" variant="primary">Simpan Maintenance</x-ui.button>
    </form>
</div>

<div class="panel table-wrap">
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Item</th>
                <th>Jenis</th>
                <th>Kondisi Setelah</th>
                <th>Catatan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($maintenances as $m)
                <tr>
                    <td data-label="Tanggal">{{ optional($m->maintenance_date)->format('d M Y') }}</td>
                    <td data-label="Item">{{ $m->item->name }}</td>
                    <td data-label="Jenis">{{ strtoupper($m->type) }}</td>
                    <td data-label="Kondisi Setelah">{{ strtoupper($m->condition_after) }}</td>
                    <td data-label="Catatan">{{ $m->notes }}</td>
                    <td data-label="Aksi">
                        <form action="{{ route('admin.maintenances.destroy', $m) }}" method="POST" class="inline" data-confirm data-confirm-title="Hapus data maintenance?" data-confirm-text="Riwayat maintenance ini akan dihapus permanen." data-confirm-icon="warning" data-confirm-button="Ya, hapus">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="bad">Hapus</x-ui.button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Belum ada data maintenance.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="panel">{{ $maintenances->links() }}</div>
@endsection
