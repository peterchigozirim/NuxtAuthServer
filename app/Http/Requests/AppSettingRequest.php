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
            'app_logo' =>'required|file|mimes:jpeg,png,jpg,gif,svg',
            'app_favicon' =>'required|file|mimes:jpeg,png,jpg,gif,svg',
            'app_description' =>'required|string',
        ];
    }
}
