<?php

namespace App\Http\Controllers\Admin;

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
use Yajra\DataTables\Facades\DataTables;

class ProductAjaxController extends Controller
{
    use MediaUploadingTrait, CsvImportTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('product_ajaxi_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = ProductAjaxi::with(['categories', 'tags', 'status', 'team'])->select(sprintf('%s.*', (new ProductAjaxi)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'product_ajaxi_show';
                $editGate      = 'product_ajaxi_edit';
                $deleteGate    = 'product_ajaxi_delete';
                $crudRoutePart = 'product-ajaxis';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('name', function ($row) {
                return $row->name ? $row->name : '';
            });
            $table->editColumn('description', function ($row) {
                return $row->description ? $row->description : '';
            });
            $table->editColumn('price', function ($row) {
                return $row->price ? $row->price : '';
            });
            $table->editColumn('category', function ($row) {
                $labels = [];
                foreach ($row->categories as $category) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $category->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('tag', function ($row) {
                $labels = [];
                foreach ($row->tags as $tag) {
                    $labels[] = sprintf('<span class="label label-info label-many">%s</span>', $tag->name);
                }

                return implode(' ', $labels);
            });
            $table->editColumn('photo', function ($row) {
                if (! $row->photo) {
                    return '';
                }
                $links = [];
                foreach ($row->photo as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('stock', function ($row) {
                return $row->stock ? $row->stock : '';
            });
            $table->addColumn('status_name', function ($row) {
                return $row->status ? $row->status->name : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'category', 'tag', 'photo', 'status']);

            return $table->make(true);
        }

        return view('admin.productAjaxis.index');
    }

    public function create()
    {
        abort_if(Gate::denies('product_ajaxi_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');

        $tags = ProductTag::pluck('name', 'id');

        $statuses = ProductStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.productAjaxis.create', compact('categories', 'statuses', 'tags'));
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

        return redirect()->route('admin.product-ajaxis.index');
    }

    public function edit(ProductAjaxi $productAjaxi)
    {
        abort_if(Gate::denies('product_ajaxi_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = ProductCategory::pluck('name', 'id');

        $tags = ProductTag::pluck('name', 'id');

        $statuses = ProductStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $productAjaxi->load('categories', 'tags', 'status', 'team');

        return view('admin.productAjaxis.edit', compact('categories', 'productAjaxi', 'statuses', 'tags'));
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

        return redirect()->route('admin.product-ajaxis.index');
    }

    public function show(ProductAjaxi $productAjaxi)
    {
        abort_if(Gate::denies('product_ajaxi_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $productAjaxi->load('categories', 'tags', 'status', 'team');

        return view('admin.productAjaxis.show', compact('productAjaxi'));
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
