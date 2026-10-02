<?php

namespace Modules\Certificate\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Certificate\Http\Requests\CertificateTypeRequest;
use Modules\Certificate\Models\CertificateType;
use Modules\Core\Models\Union;

class CertificateTypeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('permission:certificate_type.view', only: ['index', 'show']),
            new Middleware('permission:certificate_type.create', only: ['create', 'store']),
            new Middleware('permission:certificate_type.edit', only: ['edit', 'update']),
            new Middleware('permission:certificate_type.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $types = CertificateType::with('union')
            ->when(request('union_id'), fn($q, $id) => $q->where('union_id', $id))
            ->when(request('search'), function ($q, $search) {
                $q->where(function ($q) use ($search) {
                    $q->where('name_bn', 'like', "%{$search}%")
                      ->orWhere('name_en', 'like', "%{$search}%")
                      ->orWhere('code', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name_bn')
            ->paginate(20);

        $unions = Union::orderBy('name_bn')->get();

        return view('certificate::types.index', compact('types', 'unions'));
    }

    public function create()
    {
        $unions = Union::orderBy('name_bn')->get();
        return view('certificate::types.create', compact('unions'));
    }

    public function store(CertificateTypeRequest $request)
    {
        CertificateType::create($request->validated());

        return redirect()
            ->route('certificate.types.index')
            ->with('success', 'সার্টিফিকেটের ধরন তৈরি হয়েছে।');
    }

    public function show(CertificateType $type)
    {
        $type->load(['union', 'applications']);
        $type->loadCount('applications');

        return view('certificate::types.show', compact('type'));
    }

    public function edit(CertificateType $type)
    {
        $unions = Union::orderBy('name_bn')->get();
        return view('certificate::types.edit', compact('type', 'unions'));
    }

    public function update(CertificateTypeRequest $request, CertificateType $type)
    {
        $type->update($request->validated());

        return redirect()
            ->route('certificate.types.index')
            ->with('success', 'সার্টিফিকেটের ধরন আপডেট হয়েছে।');
    }

    public function destroy(CertificateType $type)
    {
        if ($type->applications()->count() > 0) {
            return back()->with('error', 'এই ধরনের আবেদন রয়েছে, ডিলিট করা যাবে না।');
        }

        $type->delete();

        return redirect()
            ->route('certificate.types.index')
            ->with('success', 'সার্টিফিকেটের ধরন ডিলিট হয়েছে।');
    }
}