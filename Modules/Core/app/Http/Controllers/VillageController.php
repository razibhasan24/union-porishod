<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Core\Http\Requests\VillageRequest;
use Modules\Core\Models\Union;
use Modules\Core\Models\Village;
use Modules\Core\Models\Ward;

class VillageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:village.view', only: ['index', 'show', 'getByWard']),
            new Middleware('permission:village.create', only: ['create', 'store']),
            new Middleware('permission:village.edit', only: ['edit', 'update']),
            new Middleware('permission:village.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $villages = Village::with(['union', 'ward'])
            ->when(request('ward_id'), fn($q, $id) => $q->where('ward_id', $id))
            ->when(request('search'), function ($q, $search) {
                $q->where('name_bn', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(20);

        $unions = Union::orderBy('name_bn')->get();
        $wards = Ward::orderBy('ward_no')->get();

        return view('core::villages.index', compact('villages', 'unions', 'wards'));
    }

    public function create()
    {
        $unions = Union::orderBy('name_bn')->get();
        $wards = Ward::orderBy('ward_no')->get();

        return view('core::villages.create', compact('unions', 'wards'));
    }

    public function store(VillageRequest $request)
    {
        Village::create($request->validated());

        return redirect()
            ->route('core.villages.index')
            ->with('success', 'গ্রাম সফলভাবে তৈরি হয়েছে।');
    }

    public function show(Village $village)
    {
        $village->load(['union', 'ward']);
        return view('core::villages.show', compact('village'));
    }

    public function edit(Village $village)
    {
        $unions = Union::orderBy('name_bn')->get();
        $wards = Ward::orderBy('ward_no')->get();

        return view('core::villages.edit', compact('village', 'unions', 'wards'));
    }

    public function update(VillageRequest $request, Village $village)
    {
        $village->update($request->validated());

        return redirect()
            ->route('core.villages.index')
            ->with('success', 'গ্রাম আপডেট হয়েছে।');
    }

    public function destroy(Village $village)
    {
        $village->delete();

        return redirect()
            ->route('core.villages.index')
            ->with('success', 'গ্রাম ডিলিট হয়েছে।');
    }

    public function getByWard(Ward $ward)
    {
        return response()->json($ward->villages);
    }
}