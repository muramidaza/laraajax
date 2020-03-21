<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequestUpdate extends FormRequest
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
			'name' => 'required|max:100',
			'phone1' => 'required|max:20'
        ];
    }
	
    public function messages()
    {
        return [
            'name.required' => 'Не введено название',
			'name.max' => 'Слишком длинное название',
			'phone1.required' => 'Не введен телефонный номер',
			'phone1.max' => 'Слишком длинный телефонный номер'
        ];
    }
}
