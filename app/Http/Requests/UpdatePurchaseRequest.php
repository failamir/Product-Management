<?php

namespace App\Http\Requests;

use App\Models\Purchase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('purchase_edit');
    }

    public function rules()
    {
        return [
            'purchase_code' => [
                'string',
                'nullable',
            ],
            'purchase_date' => [
                'required',
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
            ],
            'supplier_id' => [
                'required',
                'integer',
            ],
            'product_name' => [
                'string',
                'required',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'unit' => [
                'required',
            ],
            'unit_price' => [
                'required',
            ],
            'discount' => [
                'numeric',
            ],
            'total_discount' => [
                'numeric',
            ],
            'total_paid' => [
                'required',
            ],
            'photo' => [
                'array',
            ],
        ];
    }
}
