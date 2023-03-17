@extends('layouts.admin')
@section('content')
@can('purchase_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.purchases.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.purchase.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'Purchase', 'route' => 'admin.purchases.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.purchase.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Purchase">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.purchase_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.purchase_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.supplier') }}
                        </th>
                        <th>
                            {{ trans('cruds.supplier.fields.company_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.product_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.unit') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.unit_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.discount') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.sub_total') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.total_discount') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.transport_cost') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.grand_total') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.total_paid') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.payment_method') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($purchases as $key => $purchase)
                        <tr data-entry-id="{{ $purchase->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $purchase->id ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->purchase_code ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->purchase_date ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->supplier->name ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->supplier->company_name ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->product_name ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->quantity ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Purchase::UNIT_SELECT[$purchase->unit] ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->unit_price ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->discount ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->sub_total ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->total_discount ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->transport_cost ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->grand_total ?? '' }}
                            </td>
                            <td>
                                {{ $purchase->total_paid ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Purchase::PAYMENT_METHOD_SELECT[$purchase->payment_method] ?? '' }}
                            </td>
                            <td>
                                @foreach($purchase->photo as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ App\Models\Purchase::STATUS_SELECT[$purchase->status] ?? '' }}
                            </td>
                            <td>
                                @can('purchase_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.purchases.show', $purchase->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('purchase_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.purchases.edit', $purchase->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('purchase_delete')
                                    <form action="{{ route('admin.purchases.destroy', $purchase->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('purchase_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.purchases.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Purchase:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection