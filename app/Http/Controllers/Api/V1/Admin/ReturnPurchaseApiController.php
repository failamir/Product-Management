<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreReturnPurchaseRequest;
use App\Http\Requests\UpdateReturnPurchaseRequest;
use App\Http\Resources\Admin\ReturnPurchaseResource;
use App\Models\ReturnPurchase;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReturnPurchaseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('return_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReturnPurchaseResource(ReturnPurchase::with(['purchases'])->get());
    }

    public function store(StoreReturnPurchaseRequest $request)
    {
        $returnPurchase = ReturnPurchase::create($request->all());

        foreach ($request->input('photo', []) as $file) {
            $returnPurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        return (new ReturnPurchaseResource($returnPurchase))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ReturnPurchase $returnPurchase)
    {
        abort_if(Gate::denies('return_purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ReturnPurchaseResource($returnPurchase->load(['purchases']));
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

        return (new ReturnPurchaseResource($returnPurchase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ReturnPurchase $returnPurchase)
    {
        abort_if(Gate::denies('return_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $returnPurchase->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
