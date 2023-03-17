<?php

namespace App\Http\Requests;

use App\Models\ProductStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateProductStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('product_status_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
                'unique:product_statuses,name,' . request()->route('product_status')->id,
            ],
        ];
    }
}
