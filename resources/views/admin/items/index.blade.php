@extends('layouts.app')

@section('content')
<div class="panel">
    <h2 style="margin-top:0;">Data Alat</h2>
    <form action="{{ route('admin.items.store') }}" method="POST" class="form-grid">
        @csrf
        <label>Kode
            <input type="text" name="code" placeholder="ALT-001" required>
        </label>
        <label>Nama
            <input type="text" name="name" required>
        </label>
        <label>Kategori
            <input type="text" name="category" placeholder="OTDR / Splicer" required>
        </label>
        <label>Stok
            <input type="number" min="0" name="stock" value="0" required>
        </label>
        <label>Status
            <select name="status">
                <option value="normal">Normal</option>
                <option value="servis">Servis</option>
                <option value="rusak">Rusak</option>
            </select>
        </label>
        <label style="grid-column: span 2;">Deskripsi
            <input type="text" name="description" placeholder="Opsional">
        </label>
        <x-ui.button type="submit" variant="primary">Tambah Alat</x-ui.button>
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
                <th>Aksi</th>
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
                    <td data-label="Aksi">
                        <x-ui.button type="button" data-modal-open="edit-item-{{ $item->id }}">Edit</x-ui.button>
                        <form action="{{ route('admin.items.destroy', $item) }}" method="POST" class="inline" data-confirm data-confirm-title="Hapus data alat?" data-confirm-text="Data alat {{ $item->name }} akan dihapus permanen." data-confirm-icon="warning" data-confirm-button="Ya, hapus">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="bad">Hapus</x-ui.button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Belum ada data alat.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="panel">{{ $items->links() }}</div>

@foreach($items as $item)
    <x-ui.modal id="edit-item-{{ $item->id }}" title="Edit Data Alat - {{ $item->name }}">
        <form action="{{ route('admin.items.update', $item) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Kode
                <input type="text" name="code" value="{{ $item->code }}" required>
            </label>
            <label>Nama
                <input type="text" name="name" value="{{ $item->name }}" required>
            </label>
            <label>Kategori
                <input type="text" name="category" value="{{ $item->category }}" required>
            </label>
            <label>Stok
                <input type="number" min="0" name="stock" value="{{ $item->stock }}" required>
            </label>
            <label>Status
                <select name="status">
                    <option value="normal" @selected($item->status === 'normal')>Normal</option>
                    <option value="servis" @selected($item->status === 'servis')>Servis</option>
                    <option value="rusak" @selected($item->status === 'rusak')>Rusak</option>
                </select>
            </label>
            <label>Deskripsi
                <textarea name="description">{{ $item->description }}</textarea>
            </label>
            <div class="actions">
                <x-ui.button type="button" variant="ghost" data-modal-close>Batal</x-ui.button>
                <x-ui.button type="submit" variant="primary">Simpan Perubahan</x-ui.button>
            </div>
        </form>
    </x-ui.modal>
@endforeach
@endsection
