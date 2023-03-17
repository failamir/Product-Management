@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.purchase.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.id') }}
                        </th>
                        <td>
                            {{ $purchase->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.purchase_code') }}
                        </th>
                        <td>
                            {{ $purchase->purchase_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.purchase_date') }}
                        </th>
                        <td>
                            {{ $purchase->purchase_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.supplier') }}
                        </th>
                        <td>
                            {{ $purchase->supplier->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.product_name') }}
                        </th>
                        <td>
                            {{ $purchase->product_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.quantity') }}
                        </th>
                        <td>
                            {{ $purchase->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.unit') }}
                        </th>
                        <td>
                            {{ App\Models\Purchase::UNIT_SELECT[$purchase->unit] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.unit_price') }}
                        </th>
                        <td>
                            {{ $purchase->unit_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.discount') }}
                        </th>
                        <td>
                            {{ $purchase->discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.sub_total') }}
                        </th>
                        <td>
                            {{ $purchase->sub_total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.total_discount') }}
                        </th>
                        <td>
                            {{ $purchase->total_discount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.transport_cost') }}
                        </th>
                        <td>
                            {{ $purchase->transport_cost }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.grand_total') }}
                        </th>
                        <td>
                            {{ $purchase->grand_total }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.total_paid') }}
                        </th>
                        <td>
                            {{ $purchase->total_paid }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.payment_method') }}
                        </th>
                        <td>
                            {{ App\Models\Purchase::PAYMENT_METHOD_SELECT[$purchase->payment_method] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.purchase_note') }}
                        </th>
                        <td>
                            {!! $purchase->purchase_note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.photo') }}
                        </th>
                        <td>
                            @foreach($purchase->photo as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.purchase.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Purchase::STATUS_SELECT[$purchase->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.purchases.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection