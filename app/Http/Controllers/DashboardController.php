<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Loan;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->isTechnician()) {
            return redirect()->route('teknisi.items.index');
        }

        $stats = [
            'total_items' => Item::count(),
            'normal_items' => Item::where('status', 'normal')->count(),
            'servis_items' => Item::where('status', 'servis')->count(),
            'rusak_items' => Item::where('status', 'rusak')->count(),
            'low_stock' => Item::where('stock', '<=', 2)->count(),
        ];

        $recentLoans = Loan::with(['user', 'item'])
            ->latest('requested_at')
            ->limit(8)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentLoans'));
    }
}
