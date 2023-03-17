<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductStatusRequest;
use App\Http\Requests\UpdateProductStatusRequest;
use App\Http\Resources\Admin\ProductStatusResource;
use App\Models\ProductStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('product_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductStatusResource(ProductStatus::all());
    }

    public function store(StoreProductStatusRequest $request)
    {
        $productStatus = ProductStatus::create($request->all());

        return (new ProductStatusResource($productStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ProductStatus $productStatus)
    {
        abort_if(Gate::denies('product_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new ProductStatusResource($productStatus);
    }

    public function update(UpdateProductStatusRequest $request, ProductStatus $productStatus)
    {
        $productStatus->update($request->all());

        return (new ProductStatusResource($productStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(ProductStatus $productStatus)
    {
        abort_if(Gate::denies('product_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
