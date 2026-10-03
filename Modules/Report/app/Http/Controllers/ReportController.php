<?php

namespace Modules\Report\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Report\Exports\CertificateReportExport;
use Modules\Report\Exports\RevenueReportExport;
use Modules\Report\Services\ReportService;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    // ==================== DAILY ====================

    public function daily(Request $request)
    {
        $date = $request->filled('date') ? Carbon::parse($request->date) : today();
        $data = $this->reportService->dailyReport($date);

        return view('report::reports.daily', compact('data'));
    }

    public function dailyPdf(Request $request)
    {
        $date = $request->filled('date') ? Carbon::parse($request->date) : today();
        $data = $this->reportService->dailyReport($date);

        $pdf = Pdf::loadView('report::pdf.daily', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('daily-report-' . $date->format('Y-m-d') . '.pdf');
    }

    public function dailyExcel(Request $request)
    {
        $date = $request->filled('date') ? Carbon::parse($request->date) : today();
        $data = $this->reportService->dailyReport($date);

        $rows = [
            ['আবেদন', $data['applications']],
            ['পেমেন্ট', $data['paid']],
            ['অনুমোদিত', $data['approved']],
            ['বাতিল', $data['rejected']],
            ['প্রিন্ট', $data['printed']],
            ['আয় (৳)', $data['revenue']],
        ];

        return Excel::download(
            new CertificateReportExport($rows, ['বিষয়', 'সংখ্যা']),
            'daily-report-' . $date->format('Y-m-d') . '.xlsx'
        );
    }

    // ==================== MONTHLY ====================

    public function monthly(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $data = $this->reportService->monthlyReport($year, $month);

        return view('report::reports.monthly', compact('data'));
    }

    public function monthlyPdf(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $data = $this->reportService->monthlyReport($year, $month);

        $pdf = Pdf::loadView('report::pdf.monthly', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('monthly-report-' . $year . '-' . $month . '.pdf');
    }

    public function monthlyExcel(Request $request)
    {
        $year = $request->input('year', now()->year);
        $month = $request->input('month', now()->month);

        $data = $this->reportService->monthlyReport($year, $month);

        $rows = [
            ['মোট আবেদন', $data['applications']],
            ['অনুমোদিত', $data['approved']],
            ['বাতিল', $data['rejected']],
            ['আয় (৳)', $data['revenue']],
            ['', ''],
            ['সার্টিফিকেটের ধরন', 'সংখ্যা'],
        ];

        foreach ($data['by_type'] as $row) {
            $rows[] = [$row['name'], $row['total']];
        }

        return Excel::download(
            new CertificateReportExport($rows, ['বিষয়', 'সংখ্যা']),
            'monthly-report-' . $year . '-' . $month . '.xlsx'
        );
    }

    // ==================== REVENUE ====================

    public function revenue(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->revenueReport($start, $end);

        return view('report::reports.revenue', compact('data'));
    }

    public function revenuePdf(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->revenueReport($start, $end);

        $pdf = Pdf::loadView('report::pdf.revenue', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('revenue-report-' . $start->format('Y-m-d') . '-to-' . $end->format('Y-m-d') . '.pdf');
    }

    public function revenueExcel(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->revenueReport($start, $end);

        $rows = [
            ['মোট আয়', $data['total_revenue']],
            ['অনলাইন', $data['by_method']['online']],
            ['নগদ', $data['by_method']['cash']],
            ['', ''],
            ['তারিখ', 'আয় (৳)'],
        ];

        foreach ($data['by_day'] as $row) {
            $rows[] = [$row->date, $row->total];
        }

        return Excel::download(
            new RevenueReportExport($rows, ['বিবরণ', 'পরিমাণ']),
            'revenue-report-' . $start->format('Y-m-d') . '.xlsx'
        );
    }

    // ==================== WARD ====================

    public function ward(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->wardReport($start, $end);

        return view('report::reports.ward', compact('data'));
    }

    public function wardPdf(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->wardReport($start, $end);

        $pdf = Pdf::loadView('report::pdf.ward', compact('data'));
        $pdf->setPaper('A4', 'landscape');

        return $pdf->download('ward-report-' . $start->format('Y-m-d') . '.pdf');
    }

    public function wardExcel(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->wardReport($start, $end);

        $rows = [];
        foreach ($data['data'] as $row) {
            $rows[] = [
                $row['ward']->name_bn,
                $row['total_applications'],
                $row['approved'],
                $row['rejected'],
                $row['pending'],
                $row['revenue'],
            ];
        }

        return Excel::download(
            new CertificateReportExport(
                $rows,
                ['ওয়ার্ড', 'মোট আবেদন', 'অনুমোদিত', 'বাতিল', 'অপেক্ষমাণ', 'আয় (৳)']
            ),
            'ward-report-' . $start->format('Y-m-d') . '.xlsx'
        );
    }

    // ==================== TYPE ====================

    public function type(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->typeReport($start, $end);

        return view('report::reports.type', compact('data'));
    }

    public function typePdf(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->typeReport($start, $end);

        $pdf = Pdf::loadView('report::pdf.type', compact('data'));
        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('type-report-' . $start->format('Y-m-d') . '.pdf');
    }

    public function typeExcel(Request $request)
    {
        $start = $request->filled('start') ? Carbon::parse($request->start) : now()->startOfMonth();
        $end = $request->filled('end') ? Carbon::parse($request->end) : today();

        $data = $this->reportService->typeReport($start, $end);

        $rows = [];
        foreach ($data['data'] as $row) {
            $rows[] = [
                $row['type']->name_bn,
                $row['total_applications'],
                $row['approved'],
                $row['rejected'],
                $row['revenue'],
            ];
        }

        return Excel::download(
            new CertificateReportExport(
                $rows,
                ['সার্টিফিকেটের ধরন', 'মোট আবেদন', 'অনুমোদিত', 'বাতিল', 'আয় (৳)']
            ),
            'type-report-' . $start->format('Y-m-d') . '.xlsx'
        );
    }
}