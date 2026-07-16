@extends('layouts.app')

@section('content')
<div class="panel">
    <h2 style="margin-top:0;">Peminjaman Alat</h2>
    <p class="muted">Verifikasi permintaan pinjam, penolakan, dan proses pengembalian.</p>
</div>

<div class="panel table-wrap">
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Teknisi</th>
                <th>Alat</th>
                <th>Req Qty</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td data-label="Tanggal">{{ optional($loan->requested_at)->format('d M Y H:i') }}</td>
                    <td data-label="Teknisi">{{ $loan->user->name }}</td>
                    <td data-label="Alat">{{ $loan->item->name }}</td>
                    <td data-label="Req Qty">{{ $loan->requested_qty }}</td>
                    <td data-label="Status">
                        <span class="badge {{ $loan->status === 'approved' ? 'ok' : ($loan->status === 'pending' ? 'warn' : ($loan->status === 'returned' ? 'ok' : 'bad')) }}">
                            {{ strtoupper($loan->status) }}
                        </span>
                    </td>
                    <td data-label="Aksi">
                        @if($loan->status === 'pending')
                            <form action="{{ route('admin.loans.approve', $loan) }}" method="POST" style="margin-bottom:6px;" data-confirm data-confirm-title="Approve peminjaman ini?" data-confirm-text="Stok alat akan langsung dikurangi sesuai qty approve." data-confirm-icon="question" data-confirm-button="Ya, approve">
                                @csrf
                                <input type="number" min="1" name="approved_qty" value="{{ $loan->requested_qty }}" required>
                                <input type="date" name="due_at" value="{{ now()->addDays(3)->toDateString() }}" required>
                                <x-ui.button type="submit" variant="ok">Approve</x-ui.button>
                            </form>
                            <form action="{{ route('admin.loans.reject', $loan) }}" method="POST" data-confirm data-confirm-title="Tolak peminjaman ini?" data-confirm-text="Permintaan teknisi akan ditandai sebagai rejected." data-confirm-icon="warning" data-confirm-button="Ya, tolak">
                                @csrf
                                <input type="text" name="notes" placeholder="Alasan penolakan (opsional)">
                                <x-ui.button type="submit" variant="bad">Reject</x-ui.button>
                            </form>
                        @elseif($loan->status === 'approved')
                            <form action="{{ route('admin.loans.return', $loan) }}" method="POST" data-confirm data-confirm-title="Catat pengembalian alat?" data-confirm-text="Stok akan ditambah kembali dan status alat diperbarui." data-confirm-icon="question" data-confirm-button="Ya, simpan">
                                @csrf
                                <select name="condition_on_return" required>
                                    <option value="normal">Normal</option>
                                    <option value="servis">Servis</option>
                                    <option value="rusak">Rusak</option>
                                </select>
                                <input type="text" name="notes" placeholder="Catatan pengembalian">
                                <x-ui.button type="submit" variant="primary">Catat Kembali</x-ui.button>
                            </form>
                        @else
                            <span class="muted">Selesai diproses</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Belum ada data peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="panel">{{ $loans->links() }}</div>
@endsection
