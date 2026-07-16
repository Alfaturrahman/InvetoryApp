@extends('layouts.app')

@section('content')
<div class="panel">
    <h2 style="margin-top:0;">Laporan Ringkas</h2>
    <form method="GET" class="form-grid">
        <label>Dari Tanggal
            <input type="date" name="from" value="{{ $from->toDateString() }}">
        </label>
        <label>Sampai Tanggal
            <input type="date" name="to" value="{{ $to->toDateString() }}">
        </label>
        <x-ui.button type="submit" variant="primary">Terapkan Filter</x-ui.button>
    </form>
    <div class="actions" style="margin-top:10px;">
        <x-ui.button :href="route('admin.reports.export.pdf', ['from' => $from->toDateString(), 'to' => $to->toDateString()])">Unduh PDF</x-ui.button>
        <x-ui.button :href="route('admin.reports.export.excel', ['from' => $from->toDateString(), 'to' => $to->toDateString()])">Unduh Excel</x-ui.button>
    </div>
</div>

<div class="grid cols-2">
    <div class="panel">
        <h3 style="margin-top:0;">Ringkasan Peminjaman</h3>
        <p>Pending: <strong>{{ $loanSummary['pending'] ?? 0 }}</strong></p>
        <p>Approved: <strong>{{ $loanSummary['approved'] ?? 0 }}</strong></p>
        <p>Rejected: <strong>{{ $loanSummary['rejected'] ?? 0 }}</strong></p>
        <p>Returned: <strong>{{ $loanSummary['returned'] ?? 0 }}</strong></p>
    </div>
    <div class="panel">
        <h3 style="margin-top:0;">Maintenance</h3>
        <p>Total riwayat maintenance pada rentang tanggal: <strong>{{ $maintenanceCount }}</strong></p>
    </div>
</div>

<div class="panel table-wrap">
    <h3 style="margin-top:0;">Detail Peminjaman (Rentang Filter)</h3>
    <table style="margin-bottom:14px;">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Teknisi</th>
                <th>Alat</th>
                <th>Qty</th>
                <th>Status</th>
                <th>Jatuh Tempo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reportLoans as $loan)
                <tr>
                    <td data-label="Tanggal">{{ optional($loan->requested_at)->format('d M Y H:i') }}</td>
                    <td data-label="Teknisi">{{ $loan->user->name }}</td>
                    <td data-label="Alat">{{ $loan->item->name }}</td>
                    <td data-label="Qty">{{ $loan->approved_qty ?? $loan->requested_qty }}</td>
                    <td data-label="Status">{{ strtoupper($loan->status) }}</td>
                    <td data-label="Jatuh Tempo">{{ optional($loan->due_at)->format('d M Y') ?? '-' }}</td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Tidak ada transaksi pada rentang tanggal ini.</td></tr>
            @endforelse
        </tbody>
    </table>

    <h3 style="margin-top:0;">Alat Stok Menipis (<=2)</h3>
    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lowStockItems as $item)
                <tr>
                    <td data-label="Kode">{{ $item->code }}</td>
                    <td data-label="Nama">{{ $item->name }}</td>
                    <td data-label="Kategori">{{ $item->category }}</td>
                    <td data-label="Stok">{{ $item->stock }}</td>
                    <td data-label="Status">{{ strtoupper($item->status) }}</td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Tidak ada stok menipis.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
