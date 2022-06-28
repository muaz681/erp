<?php

namespace Luova\Sale\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class SaleSettingFV extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(Request $request)
    {
  
        return [

            'cogs' => 'required|integer',
            'shipping_fee' => 'nullable|integer',
            'discount' => 'nullable|integer',
            'tax_vax' => 'nullable|integer',
            'round_of' => 'nullable|integer',

        ];
    }
 

}
