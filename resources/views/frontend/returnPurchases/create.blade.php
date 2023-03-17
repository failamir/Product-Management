@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.create') }} {{ trans('cruds.returnPurchase.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.return-purchases.store") }}" enctype="multipart/form-data">
                        @method('POST')
                        @csrf
                        <div class="form-group">
                            <label for="return_reason">{{ trans('cruds.returnPurchase.fields.return_reason') }}</label>
                            <textarea class="form-control ckeditor" name="return_reason" id="return_reason">{!! old('return_reason') !!}</textarea>
                            @if($errors->has('return_reason'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('return_reason') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.returnPurchase.fields.return_reason_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="purchases_id">{{ trans('cruds.returnPurchase.fields.purchases') }}</label>
                            <select class="form-control select2" name="purchases_id" id="purchases_id" required>
                                @foreach($purchases as $id => $entry)
                                    <option value="{{ $id }}" {{ old('purchases_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('purchases'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('purchases') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.returnPurchase.fields.purchases_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="return_date">{{ trans('cruds.returnPurchase.fields.return_date') }}</label>
                            <input class="form-control datetime" type="text" name="return_date" id="return_date" value="{{ old('return_date') }}" required>
                            @if($errors->has('return_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('return_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.returnPurchase.fields.return_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="refund_amount">{{ trans('cruds.returnPurchase.fields.refund_amount') }}</label>
                            <input class="form-control" type="number" name="refund_amount" id="refund_amount" value="{{ old('refund_amount', '') }}" step="1">
                            @if($errors->has('refund_amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('refund_amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.returnPurchase.fields.refund_amount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="return_note">{{ trans('cruds.returnPurchase.fields.return_note') }}</label>
                            <textarea class="form-control ckeditor" name="return_note" id="return_note">{!! old('return_note') !!}</textarea>
                            @if($errors->has('return_note'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('return_note') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.returnPurchase.fields.return_note_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="photo">{{ trans('cruds.returnPurchase.fields.photo') }}</label>
                            <div class="needsclick dropzone" id="photo-dropzone">
                            </div>
                            @if($errors->has('photo'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('photo') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.returnPurchase.fields.photo_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label>{{ trans('cruds.returnPurchase.fields.status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\ReturnPurchase::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', 'Active') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.returnPurchase.fields.status_helper') }}</span>
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
                xhr.open('POST', '{{ route('frontend.return-purchases.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $returnPurchase->id ?? 0 }}');
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
    url: '{{ route('frontend.return-purchases.storeMedia') }}',
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
@if(isset($returnPurchase) && $returnPurchase->photo)
      var files = {!! json_encode($returnPurchase->photo) !!}
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