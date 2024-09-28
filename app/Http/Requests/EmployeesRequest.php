<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeesRequest extends FormRequest
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
        return [
            'name' => 'required' ,
            'email' => 'required|email|unique:users' ,
            'password' => 'required|min:5|max:10' ,
            'phone' => 'required|min:10|max:12|unique:users' ,
            'nrc_number' => 'required|unique:users' ,
            'dob' => 'required' ,
            'gender' => 'required' ,
            'address' => 'required' ,
            'employee_id' => 'required|unique:users' ,
            'department_id' => 'required' ,
            'd_o_join' => 'required' ,
            'is_present' => 'required' ,
            'pin_code' => 'required|unique:users|min:6|max:6' ,
        ];
    }
}
