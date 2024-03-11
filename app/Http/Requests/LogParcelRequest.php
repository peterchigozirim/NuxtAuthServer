<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogParcelRequest extends FormRequest
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
            'activity' => 'required|string',
            'location' => 'required|string',
            'parcel_id' =>'required',
            'status' =>'required',
        ];
    }
}
