<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KnowledgeBaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'min:3'],
            'description' => ['required'],
            'sub_category_id' => ['required'],
            'active'    =>  'in:0,1'
        ];
    }
}
