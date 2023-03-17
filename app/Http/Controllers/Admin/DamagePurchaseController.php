<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyDamagePurchaseRequest;
use App\Http\Requests\StoreDamagePurchaseRequest;
use App\Http\Requests\UpdateDamagePurchaseRequest;
use App\Models\DamagePurchase;
use App\Models\Purchase;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class DamagePurchaseController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('damage_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $damagePurchases = DamagePurchase::with(['purchases', 'media'])->get();

        return view('admin.damagePurchases.index', compact('damagePurchases'));
    }

    public function create()
    {
        abort_if(Gate::denies('damage_purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchases = Purchase::pluck('purchase_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.damagePurchases.create', compact('purchases'));
    }

    public function store(StoreDamagePurchaseRequest $request)
    {
        $damagePurchase = DamagePurchase::create($request->all());

        foreach ($request->input('photo', []) as $file) {
            $damagePurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $damagePurchase->id]);
        }

        return redirect()->route('admin.damage-purchases.index');
    }

    public function edit(DamagePurchase $damagePurchase)
    {
        abort_if(Gate::denies('damage_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchases = Purchase::pluck('purchase_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $damagePurchase->load('purchases');

        return view('admin.damagePurchases.edit', compact('damagePurchase', 'purchases'));
    }

    public function update(UpdateDamagePurchaseRequest $request, DamagePurchase $damagePurchase)
    {
        $damagePurchase->update($request->all());

        if (count($damagePurchase->photo) > 0) {
            foreach ($damagePurchase->photo as $media) {
                if (! in_array($media->file_name, $request->input('photo', []))) {
                    $media->delete();
                }
            }
        }
        $media = $damagePurchase->photo->pluck('file_name')->toArray();
        foreach ($request->input('photo', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $damagePurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
            }
        }

        return redirect()->route('admin.damage-purchases.index');
    }

    public function show(DamagePurchase $damagePurchase)
    {
        abort_if(Gate::denies('damage_purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $damagePurchase->load('purchases');

        return view('admin.damagePurchases.show', compact('damagePurchase'));
    }

    public function destroy(DamagePurchase $damagePurchase)
    {
        abort_if(Gate::denies('damage_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $damagePurchase->delete();

        return back();
    }

    public function massDestroy(MassDestroyDamagePurchaseRequest $request)
    {
        $damagePurchases = DamagePurchase::find(request('ids'));

        foreach ($damagePurchases as $damagePurchase) {
            $damagePurchase->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('damage_purchase_create') && Gate::denies('damage_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new DamagePurchase();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
