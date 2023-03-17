<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Requests\MassDestroyProductStatusRequest;
use App\Http\Requests\StoreProductStatusRequest;
use App\Http\Requests\UpdateProductStatusRequest;
use App\Models\ProductStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductStatusController extends Controller
{
    use CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('product_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productStatuses = ProductStatus::all();

        return view('admin.productStatuses.index', compact('productStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productStatuses.create');
    }

    public function store(StoreProductStatusRequest $request)
    {
        $productStatus = ProductStatus::create($request->all());

        return redirect()->route('admin.product-statuses.index');
    }

    public function edit(ProductStatus $productStatus)
    {
        abort_if(Gate::denies('product_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productStatuses.edit', compact('productStatus'));
    }

    public function update(UpdateProductStatusRequest $request, ProductStatus $productStatus)
    {
        $productStatus->update($request->all());

        return redirect()->route('admin.product-statuses.index');
    }

    public function show(ProductStatus $productStatus)
    {
        abort_if(Gate::denies('product_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.productStatuses.show', compact('productStatus'));
    }

    public function destroy(ProductStatus $productStatus)
    {
        abort_if(Gate::denies('product_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductStatusRequest $request)
    {
        $productStatuses = ProductStatus::find(request('ids'));

        foreach ($productStatuses as $productStatus) {
            $productStatus->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
