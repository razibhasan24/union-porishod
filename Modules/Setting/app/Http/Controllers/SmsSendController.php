<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Setting\Services\SmsService;

class SmsSendController extends Controller
{
    public function __construct(
        protected SmsService $smsService
    ) {}

    public function form()
    {
        return view('setting::sms.send');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'mobile' => 'required|string|max:20',
            'message' => 'required|string|max:500',
        ]);

        $log = $this->smsService->send(
            $validated['mobile'],
            $validated['message'],
            'manual',
            null,
            auth()->id()
        );

        if ($log->status === 'sent') {
            return back()->with('success', 'SMS সফলভাবে পাঠানো হয়েছে।');
        }

        return back()->with('error', 'SMS পাঠানো ব্যর্থ: ' . ($log->error_message ?? 'Unknown error'));
    }
}