<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InventoryReportExport implements FromView
{
    public function __construct(
        private readonly Carbon $from,
        private readonly Carbon $to,
        private readonly array $reportData
    ) {
    }

    public function view(): View
    {
        return view('admin.reports.excel', array_merge([
            'from' => $this->from,
            'to' => $this->to,
        ], $this->reportData));
    }
}
