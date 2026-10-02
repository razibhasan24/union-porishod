<?php

namespace Modules\Core\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Modules\Core\Http\Requests\UnionRequest;
use Modules\Core\Models\Union;
use Modules\Core\Services\UnionService;
use Illuminate\Support\Facades\Storage;

class UnionController extends Controller implements HasMiddleware
{
    public function __construct(
        protected UnionService $service
    ) {}

    public static function middleware(): array
    {
        return [
            new Middleware('permission:union.view', only: ['index', 'show']),
            new Middleware('permission:union.create', only: ['create', 'store']),
            new Middleware('permission:union.edit', only: ['edit', 'update']),
            new Middleware('permission:union.delete', only: ['destroy']),
        ];
    }

    public function index()
    {
        $unions = Union::withCount(['wards', 'villages', 'users'])
            ->latest()
            ->paginate(15);

        return view('core::unions.index', compact('unions'));
    }

    public function create()
    {
        return view('core::unions.create');
    }

    public function store(UnionRequest $request)
    {
        $data = $request->validated();
        $data = $this->handleUploads($request, $data);

        $union = $this->service->create($data);

        return redirect()
            ->route('core.unions.show', $union)
            ->with('success', 'ইউনিয়ন সফলভাবে তৈরি হয়েছে।');
    }

    public function show(Union $union)
    {
        $union->load(['wards', 'villages']);
        $union->loadCount(['wards', 'villages', 'users']);

        return view('core::unions.show', compact('union'));
    }

    public function edit(Union $union)
    {
        return view('core::unions.edit', compact('union'));
    }

    public function update(UnionRequest $request, Union $union)
    {
        $data = $request->validated();
        $data = $this->handleUploads($request, $data, $union);

        $this->service->update($union, $data);

        return redirect()
            ->route('core.unions.show', $union)
            ->with('success', 'ইউনিয়ন আপডেট হয়েছে।');
    }

    public function destroy(Union $union)
    {
        $union->delete();

        return redirect()
            ->route('core.unions.index')
            ->with('success', 'ইউনিয়ন ডিলিট হয়েছে।');
    }

    protected function handleUploads($request, array $data, ?Union $union = null): array
    {
        $files = ['logo', 'favicon', 'banner', 'letterhead', 'chairman_photo', 'chairman_signature', 'secretary_photo'];

        foreach ($files as $file) {
            if ($request->hasFile($file)) {
                if ($union && $union->$file) {
                    Storage::disk('public')->delete($union->$file);
                }
                $data[$file] = $request->file($file)->store('unions', 'public');
            }
        }

        return $data;
    }
}