<?php

namespace App\Http\Requests;

use App\Models\ReturnPurchase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyReturnPurchaseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('return_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:return_purchases,id',
        ];
    }
}
