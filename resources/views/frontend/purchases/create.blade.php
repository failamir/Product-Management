@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.purchase.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.purchases.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="purchase_code">{{ trans('cruds.purchase.fields.purchase_code') }}</label>
                            <input class="form-control" type="text" name="purchase_code" id="purchase_code" value="{{ old('purchase_code', '') }}">
                            @if($errors->has('purchase_code'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('purchase_code') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.purchase_code_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="purchase_date">{{ trans('cruds.purchase.fields.purchase_date') }}</label>
                            <input class="form-control datetime" type="text" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}" required>
                            @if($errors->has('purchase_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('purchase_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.purchase_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="supplier_id">{{ trans('cruds.purchase.fields.supplier') }}</label>
                            <select class="form-control select2" name="supplier_id" id="supplier_id" required>
                                @foreach($suppliers as $id => $entry)
                                    <option value="{{ $id }}" {{ old('supplier_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('supplier'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('supplier') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.supplier_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="product_name">{{ trans('cruds.purchase.fields.product_name') }}</label>
                            <input class="form-control" type="text" name="product_name" id="product_name" value="{{ old('product_name', '') }}" required>
                            @if($errors->has('product_name'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('product_name') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.product_name_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="quantity">{{ trans('cruds.purchase.fields.quantity') }}</label>
                            <input class="form-control" type="number" name="quantity" id="quantity" value="{{ old('quantity', '') }}" step="1" required>
                            @if($errors->has('quantity'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('quantity') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.quantity_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.purchase.fields.unit') }}</label>
                            <select class="form-control" name="unit" id="unit" required>
                                <option value disabled {{ old('unit', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Purchase::UNIT_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('unit', 'pcs') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('unit'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('unit') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.unit_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="unit_price">{{ trans('cruds.purchase.fields.unit_price') }}</label>
                            <input class="form-control" type="number" name="unit_price" id="unit_price" value="{{ old('unit_price', '') }}" step="0.01" required>
                            @if($errors->has('unit_price'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('unit_price') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.unit_price_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="discount">{{ trans('cruds.purchase.fields.discount') }}</label>
                            <input class="form-control" type="number" name="discount" id="discount" value="{{ old('discount', '') }}" step="0.01">
                            @if($errors->has('discount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('discount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.discount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="sub_total">{{ trans('cruds.purchase.fields.sub_total') }}</label>
                            <input class="form-control" type="number" name="sub_total" id="sub_total" value="{{ old('sub_total', '') }}" step="0.01">
                            @if($errors->has('sub_total'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('sub_total') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.sub_total_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="total_discount">{{ trans('cruds.purchase.fields.total_discount') }}</label>
                            <input class="form-control" type="number" name="total_discount" id="total_discount" value="{{ old('total_discount', '') }}" step="0.01">
                            @if($errors->has('total_discount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('total_discount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.total_discount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="transport_cost">{{ trans('cruds.purchase.fields.transport_cost') }}</label>
                            <input class="form-control" type="number" name="transport_cost" id="transport_cost" value="{{ old('transport_cost', '') }}" step="0.01">
                            @if($errors->has('transport_cost'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('transport_cost') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.transport_cost_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="grand_total">{{ trans('cruds.purchase.fields.grand_total') }}</label>
                            <input class="form-control" type="number" name="grand_total" id="grand_total" value="{{ old('grand_total', '') }}" step="0.01">
                            @if($errors->has('grand_total'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('grand_total') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.grand_total_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="total_paid">{{ trans('cruds.purchase.fields.total_paid') }}</label>
                            <input class="form-control" type="number" name="total_paid" id="total_paid" value="{{ old('total_paid', '') }}" step="0.01" required>
                            @if($errors->has('total_paid'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('total_paid') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.total_paid_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.purchase.fields.payment_method') }}</label>
                            <select class="form-control" name="payment_method" id="payment_method">
                                <option value disabled {{ old('payment_method', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Purchase::PAYMENT_METHOD_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('payment_method', 'Cash') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('payment_method'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('payment_method') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.payment_method_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="purchase_note">{{ trans('cruds.purchase.fields.purchase_note') }}</label>
                            <textarea class="form-control ckeditor" name="purchase_note" id="purchase_note">{!! old('purchase_note') !!}</textarea>
                            @if($errors->has('purchase_note'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('purchase_note') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.purchase_note_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="photo">{{ trans('cruds.purchase.fields.photo') }}</label>
                            <div class="needsclick dropzone" id="photo-dropzone">
                            </div>
                            @if($errors->has('photo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('photo') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.photo_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.purchase.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Purchase::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', 'Active') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.purchase.fields.status_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans('global.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('frontend.purchases.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $purchase->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

<script>
    var uploadedPhotoMap = {}
Dropzone.options.photoDropzone = {
    url: '{{ route('frontend.purchases.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="photo[]" value="' + response.name + '">')
      uploadedPhotoMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPhotoMap[file.name]
      }
      $('form').find('input[name="photo[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($purchase) && $purchase->photo)
      var files = {!! json_encode($purchase->photo) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="photo[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}

</script>
@endsection