@extends('layouts.app')

@section('content')
<div class="panel">
    <h2 style="margin-top:0;">Riwayat Peminjaman Saya</h2>
    <p class="muted">Status akan berubah setelah diverifikasi admin.</p>
</div>

<div class="panel table-wrap">
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Alat</th>
                <th>Qty Request</th>
                <th>Qty Approve</th>
                <th>Target Kembali</th>
                <th>Status</th>
                <th>Kondisi Saat Kembali</th>
            </tr>
        </thead>
        <tbody>
            @forelse($loans as $loan)
                <tr>
                    <td data-label="Tanggal">{{ optional($loan->requested_at)->format('d M Y H:i') }}</td>
                    <td data-label="Alat">{{ $loan->item->name }}</td>
                    <td data-label="Qty Request">{{ $loan->requested_qty }}</td>
                    <td data-label="Qty Approve">{{ $loan->approved_qty ?? '-' }}</td>
                    <td data-label="Target Kembali">{{ optional($loan->due_at)->format('d M Y') ?? '-' }}</td>
                    <td data-label="Status">
                        <span class="badge {{ $loan->status === 'approved' || $loan->status === 'returned' ? 'ok' : ($loan->status === 'pending' ? 'warn' : 'bad') }}">
                            {{ strtoupper($loan->status) }}
                        </span>
                    </td>
                    <td data-label="Kondisi Saat Kembali">{{ $loan->condition_on_return ? strtoupper($loan->condition_on_return) : '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="7" class="muted">Belum ada riwayat peminjaman.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="panel">{{ $loans->links() }}</div>
@endsection
