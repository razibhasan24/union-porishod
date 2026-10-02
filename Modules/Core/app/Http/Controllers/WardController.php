<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Core\Http\Requests\WardRequest;
use Modules\Core\Models\Union;
use Modules\Core\Models\Ward;
use Illuminate\Support\Facades\Storage;

class WardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:ward.view', only: ['index', 'show']),
            new Middleware('permission:ward.create', only: ['create', 'store']),
            new Middleware('permission:ward.edit', only: ['edit', 'update']),
            new Middleware('permission:ward.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $wards = Ward::with('union')
            ->when(request('union_id'), fn($q, $id) => $q->where('union_id', $id))
            ->when(request('search'), function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name_bn', 'like', "%{$search}%")
                      ->orWhere('name_en', 'like', "%{$search}%")
                      ->orWhere('ward_no', 'like', "%{$search}%");
                });
            })
            ->orderBy('union_id')
            ->orderBy('ward_no')
            ->paginate(20);

        $unions = Union::orderBy('name_bn')->get();

        return view('core::wards.index', compact('wards', 'unions'));
    }

    public function create()
    {
        $unions = Union::orderBy('name_bn')->get();
        return view('core::wards.create', compact('unions'));
    }

    public function store(WardRequest $request)
    {
        $data = $request->validated();
        $data = $this->handleUploads($request, $data);

        Ward::create($data);

        return redirect()
            ->route('core.wards.index')
            ->with('success', 'ওয়ার্ড সফলভাবে তৈরি হয়েছে।');
    }

    public function show(Ward $ward)
    {
        $ward->load(['union', 'villages']);

        return view('core::wards.show', compact('ward'));
    }

    public function edit(Ward $ward)
    {
        $unions = Union::orderBy('name_bn')->get();
        return view('core::wards.edit', compact('ward', 'unions'));
    }

    public function update(WardRequest $request, Ward $ward)
    {
        $data = $request->validated();
        $data = $this->handleUploads($request, $data, $ward);

        $ward->update($data);

        return redirect()
            ->route('core.wards.index')
            ->with('success', 'ওয়ার্ড আপডেট হয়েছে।');
    }

    public function destroy(Ward $ward)
    {
        $ward->delete();

        return redirect()
            ->route('core.wards.index')
            ->with('success', 'ওয়ার্ড ডিলিট হয়েছে।');
    }

    protected function handleUploads($request, array $data, ?Ward $ward = null): array
    {
        foreach (['member_photo', 'member_signature'] as $file) {
            if ($request->hasFile($file)) {
                if ($ward && $ward->$file) {
                    Storage::disk('public')->delete($ward->$file);
                }
                $data[$file] = $request->file($file)->store('wards', 'public');
            }
        }

        return $data;
    }
}