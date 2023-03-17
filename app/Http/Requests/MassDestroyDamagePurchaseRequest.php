<?php

namespace App\Http\Requests;

use App\Models\DamagePurchase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDamagePurchaseRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('damage_purchase_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:damage_purchases,id',
        ];
    }
}
