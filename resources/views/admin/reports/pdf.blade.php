<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Inventaris</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1d2430; font-size: 12px; }
        h1, h2, h3 { margin: 0 0 8px; }
        p { margin: 0 0 6px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 14px; }
        th, td { border: 1px solid #d7dde8; padding: 6px 8px; text-align: left; }
        th { background: #eef3fb; }
        .meta { margin-bottom: 12px; }
        .summary td { width: 50%; }
    </style>
</head>
<body>
    <h1>Laporan Inventaris Fiber Optic</h1>
    <p>PT Multitech Infomedia</p>
    <div class="meta">
        <p>Periode: {{ $from->format('d M Y') }} - {{ $to->format('d M Y') }}</p>
        <p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
    </div>

    <h3>Ringkasan</h3>
    <table class="summary">
        <tr><td>Pending</td><td>{{ $loanSummary['pending'] ?? 0 }}</td></tr>
        <tr><td>Approved</td><td>{{ $loanSummary['approved'] ?? 0 }}</td></tr>
        <tr><td>Rejected</td><td>{{ $loanSummary['rejected'] ?? 0 }}</td></tr>
        <tr><td>Returned</td><td>{{ $loanSummary['returned'] ?? 0 }}</td></tr>
        <tr><td>Total Maintenance</td><td>{{ $maintenanceCount }}</td></tr>
    </table>

    <h3>Detail Peminjaman</h3>
    <table>
        <thead>
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
                <tr>
                    <td colspan="6">Tidak ada data peminjaman pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Stok Menipis (<=2)</h3>
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
                    <td>{{ $item->code }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->category }}</td>
                    <td>{{ $item->stock }}</td>
                    <td>{{ strtoupper($item->status) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Tidak ada alat dengan stok menipis.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
