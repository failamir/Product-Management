<?php

namespace App\Http\Requests;

use App\Models\Supplier;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreSupplierRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('supplier_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'email' => [
                'string',
                'nullable',
            ],
            'phone_number' => [
                'string',
                'nullable',
            ],
            'company_name' => [
                'string',
                'required',
            ],
            'photo' => [
                'array',
            ],
        ];
    }
}
