@extends('layouts.frontend')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card">
                <div class="card-header">
                    {{ trans('global.show') }} {{ trans('cruds.expense.title') }}
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.expenses.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expense.fields.id') }}
                                    </th>
                                    <td>
                                        {{ $expense->id }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expense.fields.expense_category') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Expense::EXPENSE_CATEGORY_SELECT[$expense->expense_category] ?? '' }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expense.fields.expense_reason') }}
                                    </th>
                                    <td>
                                        {!! $expense->expense_reason !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expense.fields.expense_amount') }}
                                    </th>
                                    <td>
                                        {{ $expense->expense_amount }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expense.fields.expense_date') }}
                                    </th>
                                    <td>
                                        {{ $expense->expense_date }}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expense.fields.expense_note') }}
                                    </th>
                                    <td>
                                        {!! $expense->expense_note !!}
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expense.fields.expense_attachment_no_file_chosen') }}
                                    </th>
                                    <td>
                                        @foreach($expense->expense_attachment_no_file_chosen as $key => $media)
                                            <a href="{{ $media->getUrl() }}" target="_blank">
                                                {{ trans('global.view_file') }}
                                            </a>
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        {{ trans('cruds.expense.fields.status') }}
                                    </th>
                                    <td>
                                        {{ App\Models\Expense::STATUS_SELECT[$expense->status] ?? '' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('frontend.expenses.index') }}">
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