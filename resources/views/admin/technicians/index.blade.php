@extends('layouts.app')

@section('content')
<div class="panel">
    <h2 style="margin-top:0;">Data Teknisi</h2>
    <form action="{{ route('admin.technicians.store') }}" method="POST" class="form-grid">
        @csrf
        <label>Nama
            <input type="text" name="name" required>
        </label>
        <label>Email
            <input type="email" name="email" required>
        </label>
        <label>Password Awal
            <input type="text" name="password" value="password" required>
        </label>
        <x-ui.button type="submit" variant="primary">Tambah Teknisi</x-ui.button>
    </form>
</div>

<div class="panel table-wrap">
    <table>
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($technicians as $tech)
                <tr>
                    <td data-label="Nama">{{ $tech->name }}</td>
                    <td data-label="Email">{{ $tech->email }}</td>
                    <td data-label="Status">
                        <span class="badge {{ $tech->is_active ? 'ok' : 'bad' }}">{{ $tech->is_active ? 'AKTIF' : 'NONAKTIF' }}</span>
                    </td>
                    <td data-label="Aksi">
                        <x-ui.button type="button" data-modal-open="edit-tech-{{ $tech->id }}">Edit</x-ui.button>
                        <form action="{{ route('admin.technicians.destroy', $tech) }}" method="POST" class="inline" data-confirm data-confirm-title="Hapus akun teknisi?" data-confirm-text="Akun {{ $tech->name }} akan dihapus dari sistem." data-confirm-icon="warning" data-confirm-button="Ya, hapus akun">
                            @csrf
                            @method('DELETE')
                            <x-ui.button type="submit" variant="bad">Hapus</x-ui.button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="muted">Belum ada data teknisi.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="panel">{{ $technicians->links() }}</div>

@foreach($technicians as $tech)
    <x-ui.modal id="edit-tech-{{ $tech->id }}" title="Edit Teknisi - {{ $tech->name }}">
        <form action="{{ route('admin.technicians.update', $tech) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Nama
                <input type="text" name="name" value="{{ $tech->name }}" required>
            </label>
            <label>Email
                <input type="email" name="email" value="{{ $tech->email }}" required>
            </label>
            <label>Password Baru
                <input type="text" name="password" placeholder="Kosongkan jika tidak diubah">
            </label>
            <label><input type="checkbox" name="is_active" value="1" @checked($tech->is_active)> Aktif</label>
            <div class="actions">
                <x-ui.button type="button" variant="ghost" data-modal-close>Batal</x-ui.button>
                <x-ui.button type="submit" variant="primary">Simpan Perubahan</x-ui.button>
            </div>
        </form>
    </x-ui.modal>
@endforeach
@endsection
