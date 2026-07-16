<table>
    <tr>
        <td colspan="2"><strong>Laporan Inventaris Fiber Optic</strong></td>
    </tr>
    <tr>
        <td>Periode</td>
        <td>{{ $from->format('d M Y') }} - {{ $to->format('d M Y') }}</td>
    </tr>
    <tr>
        <td>Dicetak</td>
        <td>{{ now()->format('d M Y H:i') }}</td>
    </tr>
</table>

<table>
    <tr><td><strong>Ringkasan</strong></td><td></td></tr>
    <tr><td>Pending</td><td>{{ $loanSummary['pending'] ?? 0 }}</td></tr>
    <tr><td>Approved</td><td>{{ $loanSummary['approved'] ?? 0 }}</td></tr>
    <tr><td>Rejected</td><td>{{ $loanSummary['rejected'] ?? 0 }}</td></tr>
    <tr><td>Returned</td><td>{{ $loanSummary['returned'] ?? 0 }}</td></tr>
    <tr><td>Total Maintenance</td><td>{{ $maintenanceCount }}</td></tr>
</table>

<table>
    <thead>
        <tr>
            <th colspan="6"><strong>Detail Peminjaman</strong></th>
        </tr>
        <tr>
            <th>Tanggal</th>
            <th>Teknisi</th>
            <th>Alat</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Due Date</th>
        </tr>
    </thead>
    <tbody>
        @forelse($reportLoans as $loan)
            <tr>
                <td>{{ optional($loan->requested_at)->format('d M Y H:i') }}</td>
                <td>{{ $loan->user->name }}</td>
                <td>{{ $loan->item->name }}</td>
                <td>{{ $loan->approved_qty ?? $loan->requested_qty }}</td>
                <td>{{ strtoupper($loan->status) }}</td>
                <td>{{ optional($loan->due_at)->format('d M Y') ?? '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="6">Tidak ada data peminjaman pada periode ini.</td></tr>
        @endforelse
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th colspan="5"><strong>Stok Menipis (<=2)</strong></th>
        </tr>
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
                <td>{{ $item->code }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->category }}</td>
                <td>{{ $item->stock }}</td>
                <td>{{ strtoupper($item->status) }}</td>
            </tr>
        @empty
            <tr><td colspan="5">Tidak ada stok menipis.</td></tr>
        @endforelse
    </tbody>
</table>
