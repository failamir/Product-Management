<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\CsvImportTrait;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyProductAjaxiRequest;
use App\Http\Requests\StoreProductAjaxiRequest;
use App\Http\Requests\UpdateProductAjaxiRequest;
use App\Models\ProductAjaxi;
use App\Models\ProductCategory;
use App\Models\ProductStatus;
use App\Models\ProductTag;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class ProductAjaxController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index()
    {
        abort_if(Gate::denies('product_ajaxi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productAjaxis = ProductAjaxi::with(['categories', 'tags', 'status', 'team', 'media'])->get();

        return view('frontend.productAjaxis.index', compact('productAjaxis'));
    }

    public function create()
    {
        abort_if(Gate::denies('product_ajaxi_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');

        $tags = ProductTag::pluck('name', 'id');

        $statuses = ProductStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('frontend.productAjaxis.create', compact('categories', 'statuses', 'tags'));
    }

    public function store(StoreProductAjaxiRequest $request)
    {
        $productAjaxi = ProductAjaxi::create($request->all());
        $productAjaxi->categories()->sync($request->input('categories', []));
        $productAjaxi->tags()->sync($request->input('tags', []));
        foreach ($request->input('photo', []) as $file) {
            $productAjaxi->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('photo');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $productAjaxi->id]);
        }

        return redirect()->route('frontend.product-ajaxis.index');
    }

    public function edit(ProductAjaxi $productAjaxi)
    {
        abort_if(Gate::denies('product_ajaxi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');

        $tags = ProductTag::pluck('name', 'id');

        $statuses = ProductStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productAjaxi->load('categories', 'tags', 'status', 'team');

        return view('frontend.productAjaxis.edit', compact('categories', 'productAjaxi', 'statuses', 'tags'));
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

        return redirect()->route('frontend.product-ajaxis.index');
    }

    public function show(ProductAjaxi $productAjaxi)
    {
        abort_if(Gate::denies('product_ajaxi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productAjaxi->load('categories', 'tags', 'status', 'team');

        return view('frontend.productAjaxis.show', compact('productAjaxi'));
    }

    public function destroy(ProductAjaxi $productAjaxi)
    {
        abort_if(Gate::denies('product_ajaxi_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productAjaxi->delete();

        return back();
    }

    public function massDestroy(MassDestroyProductAjaxiRequest $request)
    {
        $productAjaxis = ProductAjaxi::find(request('ids'));

        foreach ($productAjaxis as $productAjaxi) {
            $productAjaxi->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('product_ajaxi_create') && Gate::denies('product_ajaxi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new ProductAjaxi();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
