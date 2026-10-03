<?php

namespace Modules\Setting\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Setting\Models\SmsTemplate;

class SmsTemplateController extends Controller
{
    public function index()
    {
        $templates = SmsTemplate::orderBy('key')->paginate(30);
        return view('setting::sms.templates', compact('templates'));
    }

    public function edit(SmsTemplate $template)
    {
        return view('setting::sms.template-edit', compact('template'));
    }

    public function update(Request $request, SmsTemplate $template)
    {
        $validated = $request->validate([
            'name_bn' => 'required|string|max:255',
            'body_bn' => 'required|string',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active');

        $template->update($validated);

        return redirect()
            ->route('setting.sms-templates.index')
            ->with('success', 'SMS টেমপ্লেট আপডেট হয়েছে।');
    }
}