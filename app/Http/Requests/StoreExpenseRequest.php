<?php

namespace App\Http\Requests;

use App\Models\Expense;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreExpenseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('expense_create');
    }

    public function rules()
    {
        return [
            'expense_category' => [
                'required',
            ],
            'expense_reason' => [
                'required',
            ],
            'expense_amount' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'expense_date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'expense_attachment_no_file_chosen' => [
                'array',
            ],
            'status' => [
                'required',
            ],
        ];
    }
}
