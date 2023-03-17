<?php

namespace App\Http\Requests;

use App\Models\ReturnPurchase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReturnPurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('return_purchase_edit');
    }

    public function rules()
    {
        return [
            'return_reason' => [
                'required',
            ],
            'purchases_id' => [
                'required',
                'integer',
            ],
            'return_date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'refund_amount' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'photo' => [
                'array',
            ],
        ];
    }
}
