<?php

namespace App\Http\Requests;

use App\Models\ProductStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProductStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_status_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:product_statuses',
            ],
        ];
    }
}
