@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            @can('product_ajaxi_create')
                <div style="margin-bottom: 10px;" class="row">
                    <div class="col-lg-12">
                        <a class="btn btn-success" href="{{ route('frontend.product-ajaxis.create') }}">
                            {{ trans('global.add') }} {{ trans('cruds.productAjaxi.title_singular') }}
                        </a>
                        <button class="btn btn-warning" data-toggle="modal" data-target="#csvImportModal">
                            {{ trans('global.app_csvImport') }}
                        </button>
                        @include('csvImport.modal', ['model' => 'ProductAjaxi', 'route' => 'admin.product-ajaxis.parseCsvImport'])
                    </div>
                </div>
            @endcan
            <div class="card">
                <div class="card-header">
                    {{ trans('cruds.productAjaxi.title_singular') }} {{ trans('global.list') }}
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class=" table table-bordered table-striped table-hover datatable datatable-ProductAjaxi">
                            <thead>
                                <tr>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.id') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.name') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.description') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.price') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.category') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.tag') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.photo') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.stock') }}
                                    </th>
                                    <th>
                                        {{ trans('cruds.productAjaxi.fields.status') }}
                                    </th>
                                    <th>
                                        &nbsp;
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($productAjaxis as $key => $productAjaxi)
                                    <tr data-entry-id="{{ $productAjaxi->id }}">
                                        <td>
                                            {{ $productAjaxi->id ?? '' }}
                                        </td>
                                        <td>
                                            {{ $productAjaxi->name ?? '' }}
                                        </td>
                                        <td>
                                            {{ $productAjaxi->description ?? '' }}
                                        </td>
                                        <td>
                                            {{ $productAjaxi->price ?? '' }}
                                        </td>
                                        <td>
                                            @foreach($productAjaxi->categories as $key => $item)
                                                <span>{{ $item->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($productAjaxi->tags as $key => $item)
                                                <span>{{ $item->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($productAjaxi->photo as $key => $media)
                                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                                    <img src="{{ $media->getUrl('thumb') }}">
                                                </a>
                                            @endforeach
                                        </td>
                                        <td>
                                            {{ $productAjaxi->stock ?? '' }}
                                        </td>
                                        <td>
                                            {{ $productAjaxi->status->name ?? '' }}
                                        </td>
                                        <td>
                                            @can('product_ajaxi_show')
                                                <a class="btn btn-xs btn-primary" href="{{ route('frontend.product-ajaxis.show', $productAjaxi->id) }}">
                                                    {{ trans('global.view') }}
                                                </a>
                                            @endcan

                                            @can('product_ajaxi_edit')
                                                <a class="btn btn-xs btn-info" href="{{ route('frontend.product-ajaxis.edit', $productAjaxi->id) }}">
                                                    {{ trans('global.edit') }}
                                                </a>
                                            @endcan

                                            @can('product_ajaxi_delete')
                                                <form action="{{ route('frontend.product-ajaxis.destroy', $productAjaxi->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('product_ajaxi_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('frontend.product-ajaxis.massDestroy') }}",
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
  let table = $('.datatable-ProductAjaxi:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection