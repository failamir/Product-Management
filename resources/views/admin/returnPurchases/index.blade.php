@extends('layouts.admin')
@section('content')
@can('return_purchase_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.return-purchases.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.returnPurchase.title_singular') }}
            </a>
            <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                {{ trans('global.app_csvImport') }}
            </button>
            @include('csvImport.modal', ['model' => 'ReturnPurchase', 'route' => 'admin.return-purchases.parseCsvImport'])
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.returnPurchase.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ReturnPurchase">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.purchases') }}
                        </th>
                        <th>
                            {{ trans('cruds.purchase.fields.purchase_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.return_date') }}
                        </th>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.refund_amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.photo') }}
                        </th>
                        <th>
                            {{ trans('cruds.returnPurchase.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($returnPurchases as $key => $returnPurchase)
                        <tr data-entry-id="{{ $returnPurchase->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $returnPurchase->id ?? '' }}
                            </td>
                            <td>
                                {{ $returnPurchase->purchases->purchase_code ?? '' }}
                            </td>
                            <td>
                                {{ $returnPurchase->purchases->purchase_date ?? '' }}
                            </td>
                            <td>
                                {{ $returnPurchase->return_date ?? '' }}
                            </td>
                            <td>
                                {{ $returnPurchase->refund_amount ?? '' }}
                            </td>
                            <td>
                                @foreach($returnPurchase->photo as $key => $media)
                                    <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $media->getUrl('thumb') }}">
                                    </a>
                                @endforeach
                            </td>
                            <td>
                                {{ App\Models\ReturnPurchase::STATUS_SELECT[$returnPurchase->status] ?? '' }}
                            </td>
                            <td>
                                @can('return_purchase_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.return-purchases.show', $returnPurchase->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('return_purchase_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.return-purchases.edit', $returnPurchase->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('return_purchase_delete')
                                    <form action="{{ route('admin.return-purchases.destroy', $returnPurchase->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('return_purchase_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.return-purchases.massDestroy') }}",
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
  let table = $('.datatable-ReturnPurchase:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection