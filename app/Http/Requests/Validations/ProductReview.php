<?php

namespace App\Http\Requests\Validations;

use Auth;
use App\Http\Requests\Request;

class ProductRequest extends Request
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
    public function rules()
    {

        $rules = [
            'seller_id' => 'required',
            'product_id' => 'required',
            'rate' => 'required',
            'description' => 'required',
        ];

        return $rules;
    }


   /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    // public function messages()
    // {
    //     return [
    //         'attribute_type_id.required' => trans('validation.attribute_type_id_required'),
    //     ];
    // }
}
