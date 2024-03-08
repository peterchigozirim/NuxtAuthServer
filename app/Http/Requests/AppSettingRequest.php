<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'app_name' =>'required|string',
            'app_short_name' =>'required',
            'app_email' =>'required|email',
            'app_phone' =>'required',
            'app_address' =>'required',
            'app_description' =>'required|string',
        ];
    }
}
