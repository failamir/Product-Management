<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreProductAjaxiRequest;
use App\Http\Requests\UpdateProductAjaxiRequest;
use App\Http\Resources\Admin\ProductAjaxiResource;
use App\Models\ProductAjaxi;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductAjaxApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('product_ajaxi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductAjaxiResource(ProductAjaxi::with(['categories', 'tags', 'status', 'team'])->get());
    }

    public function store(StoreProductAjaxiRequest $request)
    {
        $productAjaxi = ProductAjaxi::create($request->all());
        $productAjaxi->categories()->sync($request->input('categories', []));
        $productAjaxi->tags()->sync($request->input('tags', []));
        foreach ($request->input('photo', []) as $file) {
            $productAjaxi->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        return (new ProductAjaxiResource($productAjaxi))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProductAjaxi $productAjaxi)
    {
        abort_if(Gate::denies('product_ajaxi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductAjaxiResource($productAjaxi->load(['categories', 'tags', 'status', 'team']));
    }

    public function update(UpdateProductAjaxiRequest $request, ProductAjaxi $productAjaxi)
    {
        $productAjaxi->update($request->all());
        $productAjaxi->categories()->sync($request->input('categories', []));
        $productAjaxi->tags()->sync($request->input('tags', []));
        if (count($productAjaxi->photo) > 0) {
            foreach ($productAjaxi->photo as $media) {
                if (! in_array($media->file_name, $request->input('photo', []))) {
                    $media->delete();
                }
            }
        }
        $media = $productAjaxi->photo->pluck('file_name')->toArray();
        foreach ($request->input('photo', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $productAjaxi->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
            }
        }

        return (new ProductAjaxiResource($productAjaxi))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProductAjaxi $productAjaxi)
    {
        abort_if(Gate::denies('product_ajaxi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productAjaxi->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
