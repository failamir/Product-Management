@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.damagePurchase.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.damage-purchases.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $damagePurchase->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.damage_reason') }}
                                    </th>
                                    <td>
                                        {!! $damagePurchase->damage_reason !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.purchases') }}
                                    </th>
                                    <td>
                                        {{ $damagePurchase->purchases->purchase_code ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.damage_note') }}
                                    </th>
                                    <td>
                                        {!! $damagePurchase->damage_note !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.damage_date') }}
                                    </th>
                                    <td>
                                        {{ $damagePurchase->damage_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.photo') }}
                                    </th>
                                    <td>
                                        @foreach($damagePurchase->photo as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                <img src="{{ $media->getUrl('thumb') }}">
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\DamagePurchase::STATUS_SELECT[$damagePurchase->status] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.damage-purchases.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection