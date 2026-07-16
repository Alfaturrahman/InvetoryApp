@extends('layouts.app')

@section('content')
<div class="panel">
    <h2 style="margin-top:0;">Dashboard Admin</h2>
    <p class="muted">Ringkasan data inventaris dan aktivitas peminjaman terbaru.</p>
</div>

<div class="grid cols-4">
    <div class="panel stat"><p>Total Alat</p><h3>{{ $stats['total_items'] }}</h3></div>
    <div class="panel stat"><p>Kondisi Normal</p><h3>{{ $stats['normal_items'] }}</h3></div>
    <div class="panel stat"><p>Perlu Servis</p><h3>{{ $stats['servis_items'] }}</h3></div>
    <div class="panel stat"><p>Stok Menipis (<=2)</p><h3>{{ $stats['low_stock'] }}</h3></div>
</div>

<div class="panel">
    <h3 style="margin-top:0;">Aktivitas Peminjaman Terbaru</h3>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Teknisi</th>
                    <th>Alat</th>
                    <th>Qty</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentLoans as $loan)
                    <tr>
                        <td data-label="Tanggal">{{ optional($loan->requested_at)->format('d M Y H:i') }}</td>
                        <td data-label="Teknisi">{{ $loan->user->name }}</td>
                        <td data-label="Alat">{{ $loan->item->name }}</td>
                        <td data-label="Qty">{{ $loan->requested_qty }}</td>
                        <td data-label="Status">{{ strtoupper($loan->status) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="muted">Belum ada transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
