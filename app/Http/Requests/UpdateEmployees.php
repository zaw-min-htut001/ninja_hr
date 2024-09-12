<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployees extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $id = $this->route('employee');
        return [
            'name' => 'required' ,
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'password' => 'required|min:5|max:10' ,
            'phone' => [
                'required',
                'min:10',
                'max:12',
                Rule::unique('users', 'phone')->ignore($id),
            ],
            'nrc_number' => [
                'required',
                Rule::unique('users', 'nrc_number')->ignore($id),
            ],
            'dob' => 'required' ,
            'gender' => 'required' ,
            'address' => 'required' ,
            'employee_id' => [
                'required',
                Rule::unique('users', 'employee_id')->ignore($id),
            ],
            'department_id' => 'required' ,
            'd_o_join' => 'required' ,
            'is_present' => 'required' ,
        ];
    }
}
