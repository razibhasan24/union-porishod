<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Core\Models\Setting;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:setting.view')->only(['index']);
        $this->middleware('permission:setting.edit')->only(['update']);
    }

    public function index()
    {
        $settings = Setting::orderBy('group')
            ->orderBy('sort_order')
            ->get()
            ->groupBy('group');

        return view('core::settings.index', compact('settings'));
    }

    public function update(\Illuminate\Http\Request $request)
    {
        foreach ($request->except(['_token', '_method']) as $key => $value) {
            Setting::where('key', $key)->update(['value' => $value]);
        }

        return back()->with('success', 'সেটিংস আপডেট হয়েছে।');
    }
}