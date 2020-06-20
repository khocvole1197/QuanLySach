<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatAuthor extends FormRequest
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
        return [
            'name_authors' => 'required|unique:authors',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'không được bỏ trống',
            'unique'=>'tên đã tồn tại'
        ];
    }
}
