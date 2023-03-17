@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('damage_purchase_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.damage-purchases.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.damagePurchase.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'DamagePurchase', 'route' => 'admin.damage-purchases.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.damagePurchase.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-DamagePurchase">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.purchases') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.purchase.fields.purchase_date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.damage_date') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.photo') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.damagePurchase.fields.status') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($damagePurchases as $key => $damagePurchase)
                                    <tr data-entry-id="{{ $damagePurchase->id }}">
                                        <td>
                                            {{ $damagePurchase->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $damagePurchase->purchases->purchase_code ?? '' }}
                                        </td>
                                        <td>
                                            {{ $damagePurchase->purchases->purchase_date ?? '' }}
                                        </td>
                                        <td>
                                            {{ $damagePurchase->damage_date ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($damagePurchase->photo as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ App\Models\DamagePurchase::STATUS_SELECT[$damagePurchase->status] ?? '' }}
                                        </td>
                                        <td>
                                            @can('damage_purchase_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.damage-purchases.show', $damagePurchase->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('damage_purchase_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.damage-purchases.edit', $damagePurchase->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('damage_purchase_delete')
                                                <form action="{{ route('frontend.damage-purchases.destroy', $damagePurchase->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

        </div>
    </div>
</div>
@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('damage_purchase_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.damage-purchases.massDestroy') }}",
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
  let table = $('.datatable-DamagePurchase:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection