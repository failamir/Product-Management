@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.returnPurchase.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.return-purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.id') }}
                        </th>
                        <td>
                            {{ $returnPurchase->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.return_reason') }}
                        </th>
                        <td>
                            {!! $returnPurchase->return_reason !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.purchases') }}
                        </th>
                        <td>
                            {{ $returnPurchase->purchases->purchase_code ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.return_date') }}
                        </th>
                        <td>
                            {{ $returnPurchase->return_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.refund_amount') }}
                        </th>
                        <td>
                            {{ $returnPurchase->refund_amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.return_note') }}
                        </th>
                        <td>
                            {!! $returnPurchase->return_note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.photo') }}
                        </th>
                        <td>
                            @foreach($returnPurchase->photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\ReturnPurchase::STATUS_SELECT[$returnPurchase->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.return-purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection