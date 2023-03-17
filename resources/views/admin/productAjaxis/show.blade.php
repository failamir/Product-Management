@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.productAjaxi.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.product-ajaxis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.id') }}
                        </th>
                        <td>
                            {{ $productAjaxi->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.name') }}
                        </th>
                        <td>
                            {{ $productAjaxi->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.description') }}
                        </th>
                        <td>
                            {{ $productAjaxi->description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.price') }}
                        </th>
                        <td>
                            {{ $productAjaxi->price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.category') }}
                        </th>
                        <td>
                            @foreach($productAjaxi->categories as $key => $category)
                                <span class="label label-info">{{ $category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.tag') }}
                        </th>
                        <td>
                            @foreach($productAjaxi->tags as $key => $tag)
                                <span class="label label-info">{{ $tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.photo') }}
                        </th>
                        <td>
                            @foreach($productAjaxi->photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.stock') }}
                        </th>
                        <td>
                            {{ $productAjaxi->stock }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productAjaxi.fields.status') }}
                        </th>
                        <td>
                            {{ $productAjaxi->status->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.product-ajaxis.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection