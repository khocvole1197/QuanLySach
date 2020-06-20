<?php

namespace App\Http\Requests;

use App\Rules\CheckDateRule;
use Illuminate\Foundation\Http\FormRequest;

class DateTime extends FormRequest
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
            'dayform'        => 'date',
            'dayto'          => ['date','after_or_equal:dayform',new CheckDateRule(request()->dayform)],
        ];
    }
    public function messages()
    {
        return [
            'after_or_equal' => 'ngày trả bắt đầu từ ngày mượn. tối đa 4 ngày',
        ];
    }
}
