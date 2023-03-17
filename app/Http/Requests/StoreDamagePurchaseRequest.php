<?php

namespace App\Http\Requests;

use App\Models\DamagePurchase;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDamagePurchaseRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('damage_purchase_create');
    }

    public function rules()
    {
        return [
            'damage_reason' => [
                'required',
            ],
            'purchases_id' => [
                'required',
                'integer',
            ],
            'damage_date' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'photo' => [
                'array',
            ],
        ];
    }
}
