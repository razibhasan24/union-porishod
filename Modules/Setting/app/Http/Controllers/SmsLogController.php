<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Setting\Models\SmsLog;

class SmsLogController extends Controller
{
    public function index()
    {
        $logs = SmsLog::with('user')
            ->when(request('status'), fn($q, $s) => $q->where('status', $s))
            ->when(request('gateway'), fn($q, $g) => $q->where('gateway', $g))
            ->when(request('search'), function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('mobile', 'like', "%{$search}%")
                      ->orWhere('message', 'like', "%{$search}%")
                      ->orWhere('template_key', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(30);

        $stats = [
            'total' => SmsLog::count(),
            'sent' => SmsLog::where('status', 'sent')->count(),
            'failed' => SmsLog::where('status', 'failed')->count(),
            'today' => SmsLog::whereDate('created_at', today())->count(),
        ];

        return view('setting::sms.logs', compact('logs', 'stats'));
    }

    public function show(SmsLog $log)
    {
        $log->load('user');
        return view('setting::sms.log-detail', compact('log'));
    }
}