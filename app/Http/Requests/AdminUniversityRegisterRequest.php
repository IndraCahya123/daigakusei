<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUniversityRegisterRequest extends FormRequest
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
        'admin_name' => 'required|string|min:6',
        'admin_email' => 'required|string|email',
        'university' => 'required|string',
        'phone' => 'required|numeric|min:11',
        'password' => 'required|string|min:8|confirmed',
        ];
    }
}
