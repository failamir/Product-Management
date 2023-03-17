@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.damagePurchase.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.damage-purchases.update", [$damagePurchase->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="damage_reason">{{ trans('cruds.damagePurchase.fields.damage_reason') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('damage_reason') ? 'is-invalid' : '' }}" name="damage_reason" id="damage_reason">{!! old('damage_reason', $damagePurchase->damage_reason) !!}</textarea>
                @if($errors->has('damage_reason'))
                    <div class="invalid-feedback">
                        {{ $errors->first('damage_reason') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.damagePurchase.fields.damage_reason_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="purchases_id">{{ trans('cruds.damagePurchase.fields.purchases') }}</label>
                <select class="form-control select2 {{ $errors->has('purchases') ? 'is-invalid' : '' }}" name="purchases_id" id="purchases_id" required>
                    @foreach($purchases as $id => $entry)
                        <option value="{{ $id }}" {{ (old('purchases_id') ? old('purchases_id') : $damagePurchase->purchases->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('purchases'))
                    <div class="invalid-feedback">
                        {{ $errors->first('purchases') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.damagePurchase.fields.purchases_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="damage_note">{{ trans('cruds.damagePurchase.fields.damage_note') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('damage_note') ? 'is-invalid' : '' }}" name="damage_note" id="damage_note">{!! old('damage_note', $damagePurchase->damage_note) !!}</textarea>
                @if($errors->has('damage_note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('damage_note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.damagePurchase.fields.damage_note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="damage_date">{{ trans('cruds.damagePurchase.fields.damage_date') }}</label>
                <input class="form-control datetime {{ $errors->has('damage_date') ? 'is-invalid' : '' }}" type="text" name="damage_date" id="damage_date" value="{{ old('damage_date', $damagePurchase->damage_date) }}">
                @if($errors->has('damage_date'))
                    <div class="invalid-feedback">
                        {{ $errors->first('damage_date') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.damagePurchase.fields.damage_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans('cruds.damagePurchase.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.damagePurchase.fields.photo_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.damagePurchase.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\DamagePurchase::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $damagePurchase->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.damagePurchase.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
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
                xhr.open('POST', '{{ route('admin.damage-purchases.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $damagePurchase->id ?? 0 }}');
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
    url: '{{ route('admin.damage-purchases.storeMedia') }}',
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
@if(isset($damagePurchase) && $damagePurchase->photo)
      var files = {!! json_encode($damagePurchase->photo) !!}
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