<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Report\Services\ReportService;

class DashboardController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    public function index()
    {
        $stats = $this->reportService->getDashboardStats();

        // Last 30 days data for chart
        $last30Days = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $last30Days[] = [
                'date' => $date->format('d M'),
                'applications' => \Modules\Certificate\Models\CertificateApplication::whereDate('created_at', $date)->count(),
                'revenue' => \Modules\Payment\Models\Payment::where('status', 'success')->whereDate('paid_at', $date)->sum('amount'),
            ];
        }

        return view('report::dashboard.index', compact('stats', 'last30Days'));
    }
}