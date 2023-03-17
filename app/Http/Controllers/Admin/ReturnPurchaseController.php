<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyReturnPurchaseRequest;
use App\Http\Requests\StoreReturnPurchaseRequest;
use App\Http\Requests\UpdateReturnPurchaseRequest;
use App\Models\Purchase;
use App\Models\ReturnPurchase;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ReturnPurchaseController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('return_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $returnPurchases = ReturnPurchase::with(['purchases', 'media'])->get();

        return view('admin.returnPurchases.index', compact('returnPurchases'));
    }

    public function create()
    {
        abort_if(Gate::denies('return_purchase_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchases = Purchase::pluck('purchase_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.returnPurchases.create', compact('purchases'));
    }

    public function store(StoreReturnPurchaseRequest $request)
    {
        $returnPurchase = ReturnPurchase::create($request->all());

        foreach ($request->input('photo', []) as $file) {
            $returnPurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $returnPurchase->id]);
        }

        return redirect()->route('admin.return-purchases.index');
    }

    public function edit(ReturnPurchase $returnPurchase)
    {
        abort_if(Gate::denies('return_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $purchases = Purchase::pluck('purchase_code', 'id')->prepend(trans('global.pleaseSelect'), '');

        $returnPurchase->load('purchases');

        return view('admin.returnPurchases.edit', compact('purchases', 'returnPurchase'));
    }

    public function update(UpdateReturnPurchaseRequest $request, ReturnPurchase $returnPurchase)
    {
        $returnPurchase->update($request->all());

        if (count($returnPurchase->photo) > 0) {
            foreach ($returnPurchase->photo as $media) {
                if (! in_array($media->file_name, $request->input('photo', []))) {
                    $media->delete();
                }
            }
        }
        $media = $returnPurchase->photo->pluck('file_name')->toArray();
        foreach ($request->input('photo', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $returnPurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
            }
        }

        return redirect()->route('admin.return-purchases.index');
    }

    public function show(ReturnPurchase $returnPurchase)
    {
        abort_if(Gate::denies('return_purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $returnPurchase->load('purchases');

        return view('admin.returnPurchases.show', compact('returnPurchase'));
    }

    public function destroy(ReturnPurchase $returnPurchase)
    {
        abort_if(Gate::denies('return_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $returnPurchase->delete();

        return back();
    }

    public function massDestroy(MassDestroyReturnPurchaseRequest $request)
    {
        $returnPurchases = ReturnPurchase::find(request('ids'));

        foreach ($returnPurchases as $returnPurchase) {
            $returnPurchase->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('return_purchase_create') && Gate::denies('return_purchase_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ReturnPurchase();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
