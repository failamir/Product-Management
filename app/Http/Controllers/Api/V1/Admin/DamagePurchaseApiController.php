<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreDamagePurchaseRequest;
use App\Http\Requests\UpdateDamagePurchaseRequest;
use App\Http\Resources\Admin\DamagePurchaseResource;
use App\Models\DamagePurchase;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DamagePurchaseApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('damage_purchase_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DamagePurchaseResource(DamagePurchase::with(['purchases'])->get());
    }

    public function store(StoreDamagePurchaseRequest $request)
    {
        $damagePurchase = DamagePurchase::create($request->all());

        foreach ($request->input('photo', []) as $file) {
            $damagePurchase->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        return (new DamagePurchaseResource($damagePurchase))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(DamagePurchase $damagePurchase)
    {
        abort_if(Gate::denies('damage_purchase_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new DamagePurchaseResource($damagePurchase->load(['purchases']));
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

        return (new DamagePurchaseResource($damagePurchase))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(DamagePurchase $damagePurchase)
    {
        abort_if(Gate::denies('damage_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $damagePurchase->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
