@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.edit') }} {{ trans('cruds.expense.title_singular') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("frontend.expenses.update", [$expense->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.expense.fields.expense_category') }}</label>
                            <select class="form-control" name="expense_category" id="expense_category" required>
                                <option value disabled {{ old('expense_category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expense::EXPENSE_CATEGORY_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('expense_category', $expense->expense_category) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('expense_category'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('expense_category') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_category_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="expense_reason">{{ trans('cruds.expense.fields.expense_reason') }}</label>
                            <textarea class="form-control ckeditor" name="expense_reason" id="expense_reason">{!! old('expense_reason', $expense->expense_reason) !!}</textarea>
                            @if($errors->has('expense_reason'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('expense_reason') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_reason_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="expense_amount">{{ trans('cruds.expense.fields.expense_amount') }}</label>
                            <input class="form-control" type="number" name="expense_amount" id="expense_amount" value="{{ old('expense_amount', $expense->expense_amount) }}" step="1" required>
                            @if($errors->has('expense_amount'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('expense_amount') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_amount_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required" for="expense_date">{{ trans('cruds.expense.fields.expense_date') }}</label>
                            <input class="form-control datetime" type="text" name="expense_date" id="expense_date" value="{{ old('expense_date', $expense->expense_date) }}" required>
                            @if($errors->has('expense_date'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('expense_date') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_date_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="expense_note">{{ trans('cruds.expense.fields.expense_note') }}</label>
                            <textarea class="form-control ckeditor" name="expense_note" id="expense_note">{!! old('expense_note', $expense->expense_note) !!}</textarea>
                            @if($errors->has('expense_note'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('expense_note') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_note_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="expense_attachment_no_file_chosen">{{ trans('cruds.expense.fields.expense_attachment_no_file_chosen') }}</label>
                            <div class="needsclick dropzone" id="expense_attachment_no_file_chosen-dropzone">
                            </div>
                            @if($errors->has('expense_attachment_no_file_chosen'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('expense_attachment_no_file_chosen') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.expense_attachment_no_file_chosen_helper') }}</span>
                        </div>
                        <div class="form-group">
                            <label class="required">{{ trans('cruds.expense.fields.status') }}</label>
                            <select class="form-control" name="status" id="status" required>
                                <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                                @foreach(App\Models\Expense::STATUS_SELECT as $key => $label)
                                    <option value="{{ $key }}" {{ old('status', $expense->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('status'))
                                <div class="invalid-feedback">
                                    {{ $errors->first('status') }}
                                </div>
                            @endif
                            <span class="help-block">{{ trans('cruds.expense.fields.status_helper') }}</span>
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
                xhr.open('POST', '{{ route('frontend.expenses.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $expense->id ?? 0 }}');
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
    var uploadedExpenseAttachmentNoFileChosenMap = {}
Dropzone.options.expenseAttachmentNoFileChosenDropzone = {
    url: '{{ route('frontend.expenses.storeMedia') }}',
    maxFilesize: 8, // MB
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 8
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="expense_attachment_no_file_chosen[]" value="' + response.name + '">')
      uploadedExpenseAttachmentNoFileChosenMap[file.name] = response.name
    },
    removedfile: function (file) {
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedExpenseAttachmentNoFileChosenMap[file.name]
      }
      $('form').find('input[name="expense_attachment_no_file_chosen[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($expense) && $expense->expense_attachment_no_file_chosen)
          var files =
            {!! json_encode($expense->expense_attachment_no_file_chosen) !!}
              for (var i in files) {
              var file = files[i]
              this.options.addedfile.call(this, file)
              file.previewElement.classList.add('dz-complete')
              $('form').append('<input type="hidden" name="expense_attachment_no_file_chosen[]" value="' + file.file_name + '">')
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