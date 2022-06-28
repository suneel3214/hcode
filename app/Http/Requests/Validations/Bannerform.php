<?php

namespace App\Http\Requests\Validations;

use Auth;
use App\Http\Requests\Request;

class Bannerform extends Request
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
            'heading' => 'required',
            'highlight_text' => 'required',
            'link' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'banner_location' => 'required',
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
