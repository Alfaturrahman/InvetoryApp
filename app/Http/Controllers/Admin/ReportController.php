<?php

namespace App\Http\Controllers\Admin;

use App\Exports\InventoryReportExport;
use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Loan;
use App\Models\Maintenance;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);
        $reportData = $this->buildReportData($from, $to);

        return view('admin.reports.index', array_merge(
            ['from' => $from, 'to' => $to],
            $reportData
        ));
    }

    public function exportPdf(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);
        $reportData = $this->buildReportData($from, $to);

        $pdf = Pdf::loadView('admin.reports.pdf', array_merge(
            ['from' => $from, 'to' => $to],
            $reportData
        ));

        return $pdf->download('laporan-inventaris-'.$from->toDateString().'-'.$to->toDateString().'.pdf');
    }

    public function exportExcel(Request $request)
    {
        [$from, $to] = $this->resolveDateRange($request);
        $reportData = $this->buildReportData($from, $to);

        $filename = 'laporan-inventaris-'.$from->toDateString().'-'.$to->toDateString().'.xlsx';

        return Excel::download(new InventoryReportExport($from, $to, $reportData), $filename);
    }

    private function resolveDateRange(Request $request): array
    {
        $from = $request->date('from')
            ? Carbon::parse($request->date('from'))->startOfDay()
            : now()->startOfMonth()->startOfDay();

        $to = $request->date('to')
            ? Carbon::parse($request->date('to'))->endOfDay()
            : now()->endOfMonth()->endOfDay();

        if ($from->gt($to)) {
            [$from, $to] = [$to->copy()->startOfDay(), $from->copy()->endOfDay()];
        }

        return [$from, $to];
    }

    private function buildReportData(Carbon $from, Carbon $to): array
    {
        $loanSummary = Loan::whereBetween('requested_at', [$from, $to])
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $maintenanceCount = Maintenance::whereBetween('maintenance_date', [$from->toDateString(), $to->toDateString()])->count();

        $reportLoans = Loan::with(['user', 'item'])
            ->whereBetween('requested_at', [$from, $to])
            ->latest('requested_at')
            ->get();

        $lowStockItems = Item::where('stock', '<=', 2)
            ->orderBy('stock')
            ->orderBy('name')
            ->get();

        return [
            'loanSummary' => $loanSummary,
            'maintenanceCount' => $maintenanceCount,
            'reportLoans' => $reportLoans,
            'lowStockItems' => $lowStockItems,
        ];
    }
}
