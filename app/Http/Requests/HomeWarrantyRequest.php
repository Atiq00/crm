<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class HomeWarrantyRequest extends FormRequest
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
            'record_id' => 'required',
            'first_name' => 'required',
            'last_name' => 'nullable',
            'client' => 'required',
            'phone' => 'required|unique:home_warranties,phone',
        ];

        return $rules;
    }
}
