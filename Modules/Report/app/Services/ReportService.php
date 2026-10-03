<?php

namespace Modules\Report\app\Services;

namespace Modules\Report\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\Certificate\Models\CertificateApplication;
use Modules\Certificate\Models\CertificateType;
use Modules\Certificate\Models\IssuedCertificate;
use Modules\Core\Models\Ward;
use Modules\Payment\Models\Payment;

class ReportService
{
    /**
     * Dashboard statistics
     */
    public function getDashboardStats(): array
    {
        $today = today();
        $thisMonth = now()->startOfMonth();

        return [
            'today' => [
                'applications' => CertificateApplication::whereDate('created_at', $today)->count(),
                'approved' => CertificateApplication::whereDate('chairman_action_at', $today)
                    ->where('status', 'chairman_approved')->count(),
                'printed' => IssuedCertificate::whereDate('last_printed_at', $today)->count(),
                'revenue' => Payment::where('status', 'success')
                    ->whereDate('paid_at', $today)->sum('amount'),
            ],
            'this_month' => [
                'applications' => CertificateApplication::where('created_at', '>=', $thisMonth)->count(),
                'approved' => CertificateApplication::where('chairman_action_at', '>=', $thisMonth)
                    ->where('status', 'chairman_approved')->count(),
                'revenue' => Payment::where('status', 'success')
                    ->where('paid_at', '>=', $thisMonth)->sum('amount'),
            ],
            'total' => [
                'applications' => CertificateApplication::count(),
                'approved' => CertificateApplication::where('status', 'chairman_approved')->count(),
                'pending' => CertificateApplication::whereIn('status', [
                    'sent_to_ward', 'sent_to_chairman',
                ])->count(),
                'revenue' => Payment::where('status', 'success')->sum('amount'),
            ],
        ];
    }

    /**
     * Daily Report
     */
    public function dailyReport(Carbon $date): array
    {
        return [
            'date' => $date,
            'applications' => CertificateApplication::whereDate('created_at', $date)->count(),
            'paid' => Payment::where('status', 'success')->whereDate('paid_at', $date)->count(),
            'approved' => CertificateApplication::where('status', 'chairman_approved')
                ->whereDate('chairman_action_at', $date)->count(),
            'rejected' => CertificateApplication::whereIn('status', ['ward_rejected', 'chairman_rejected'])
                ->whereDate('updated_at', $date)->count(),
            'printed' => IssuedCertificate::whereDate('last_printed_at', $date)->count(),
            'revenue' => Payment::where('status', 'success')->whereDate('paid_at', $date)->sum('amount'),
            'by_type' => $this->applicationsByType($date, $date),
            'by_method' => [
                'online' => Payment::where('status', 'success')->whereDate('paid_at', $date)->where('method', 'online')->sum('amount'),
                'cash' => Payment::where('status', 'success')->whereDate('paid_at', $date)->where('method', 'cash')->sum('amount'),
            ],
        ];
    }

    /**
     * Monthly Report
     */
    public function monthlyReport(int $year, int $month): array
    {
        $start = Carbon::create($year, $month, 1)->startOfMonth();
        $end = $start->copy()->endOfMonth();

        return [
            'year' => $year,
            'month' => $month,
            'month_name' => $start->format('F'),
            'applications' => CertificateApplication::whereBetween('created_at', [$start, $end])->count(),
            'approved' => CertificateApplication::where('status', 'chairman_approved')
                ->whereBetween('chairman_action_at', [$start, $end])->count(),
            'rejected' => CertificateApplication::whereIn('status', ['ward_rejected', 'chairman_rejected'])
                ->whereBetween('updated_at', [$start, $end])->count(),
            'revenue' => Payment::where('status', 'success')
                ->whereBetween('paid_at', [$start, $end])->sum('amount'),
            'by_type' => $this->applicationsByType($start, $end),
            'by_ward' => $this->applicationsByWard($start, $end),
            'by_method' => [
                'online' => Payment::where('status', 'success')
                    ->whereBetween('paid_at', [$start, $end])
                    ->where('method', 'online')->sum('amount'),
                'cash' => Payment::where('status', 'success')
                    ->whereBetween('paid_at', [$start, $end])
                    ->where('method', 'cash')->sum('amount'),
            ],
            'daily_breakdown' => $this->dailyBreakdown($start, $end),
        ];
    }

    /**
     * Revenue Report
     */
    public function revenueReport(Carbon $start, Carbon $end): array
    {
        $totalRevenue = Payment::where('status', 'success')
            ->whereBetween('paid_at', [$start, $end])->sum('amount');

        $totalRefund = Payment::where('status', 'failed')
            ->whereBetween('paid_at', [$start, $end])->sum('amount');

        return [
            'start' => $start,
            'end' => $end,
            'total_revenue' => $totalRevenue,
            'total_refund' => $totalRefund,
            'net_revenue' => $totalRevenue - $totalRefund,
            'by_gateway' => Payment::where('status', 'success')
                ->whereBetween('paid_at', [$start, $end])
                ->select('gateway', DB::raw('SUM(amount) as total'), DB::raw('COUNT(*) as count'))
                ->groupBy('gateway')
                ->get(),
            'by_method' => [
                'online' => Payment::where('status', 'success')
                    ->whereBetween('paid_at', [$start, $end])
                    ->where('method', 'online')->sum('amount'),
                'cash' => Payment::where('status', 'success')
                    ->whereBetween('paid_at', [$start, $end])
                    ->where('method', 'cash')->sum('amount'),
            ],
            'by_day' => Payment::where('status', 'success')
                ->whereBetween('paid_at', [$start, $end])
                ->select(DB::raw('DATE(paid_at) as date'), DB::raw('SUM(amount) as total'))
                ->groupBy('date')
                ->orderBy('date')
                ->get(),
        ];
    }

    /**
     * Ward-wise Report
     */
    public function wardReport(Carbon $start, Carbon $end): array
    {
        $wards = Ward::with('union')->get();

        $data = $wards->map(function ($ward) use ($start, $end) {
            $apps = CertificateApplication::where('ward_id', $ward->id)
                ->whereBetween('created_at', [$start, $end]);

            return [
                'ward' => $ward,
                'total_applications' => (clone $apps)->count(),
                'approved' => (clone $apps)->where('status', 'chairman_approved')->count(),
                'rejected' => (clone $apps)->whereIn('status', ['ward_rejected', 'chairman_rejected'])->count(),
                'pending' => (clone $apps)->whereIn('status', ['sent_to_ward', 'sent_to_chairman'])->count(),
                'revenue' => Payment::where('status', 'success')
                    ->whereHas('application', fn($q) => $q->where('ward_id', $ward->id))
                    ->whereBetween('paid_at', [$start, $end])
                    ->sum('amount'),
            ];
        });

        return [
            'start' => $start,
            'end' => $end,
            'data' => $data,
            'totals' => [
                'applications' => $data->sum('total_applications'),
                'approved' => $data->sum('approved'),
                'rejected' => $data->sum('rejected'),
                'revenue' => $data->sum('revenue'),
            ],
        ];
    }

    /**
     * Type-wise Report
     */
    public function typeReport(Carbon $start, Carbon $end): array
    {
        $types = CertificateType::all();

        $data = $types->map(function ($type) use ($start, $end) {
            $apps = CertificateApplication::where('certificate_type_id', $type->id)
                ->whereBetween('created_at', [$start, $end]);

            return [
                'type' => $type,
                'total_applications' => (clone $apps)->count(),
                'approved' => (clone $apps)->where('status', 'chairman_approved')->count(),
                'rejected' => (clone $apps)->whereIn('status', ['ward_rejected', 'chairman_rejected'])->count(),
                'revenue' => Payment::where('status', 'success')
                    ->whereHas('application', fn($q) => $q->where('certificate_type_id', $type->id))
                    ->whereBetween('paid_at', [$start, $end])
                    ->sum('amount'),
            ];
        });

        return [
            'start' => $start,
            'end' => $end,
            'data' => $data,
            'totals' => [
                'applications' => $data->sum('total_applications'),
                'approved' => $data->sum('approved'),
                'revenue' => $data->sum('revenue'),
            ],
        ];
    }

    // ==================== HELPERS ====================

    protected function applicationsByType(Carbon $start, Carbon $end)
    {
        return CertificateApplication::whereBetween('created_at', [$start, $end])
            ->select('certificate_type_id', DB::raw('COUNT(*) as total'))
            ->with('certificateType:id,name_bn')
            ->groupBy('certificate_type_id')
            ->get()
            ->map(fn($row) => [
                'name' => $row->certificateType->name_bn ?? '-',
                'total' => $row->total,
            ]);
    }

    protected function applicationsByWard(Carbon $start, Carbon $end)
    {
        return CertificateApplication::whereBetween('created_at', [$start, $end])
            ->select('ward_id', DB::raw('COUNT(*) as total'))
            ->with('ward:id,name_bn')
            ->groupBy('ward_id')
            ->get()
            ->map(fn($row) => [
                'name' => $row->ward->name_bn ?? '-',
                'total' => $row->total,
            ]);
    }

    protected function dailyBreakdown(Carbon $start, Carbon $end)
    {
        return CertificateApplication::whereBetween('created_at', [$start, $end])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }
}