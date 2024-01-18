<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParcelRequest extends FormRequest
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
            'sender_name' => 'required',
            'recepient' => 'required',
            'recepient_email' => 'required|email',
            'recepient_phone' => 'required',
            'recepient_address' => 'required',
            'recepient_country' => 'required',
            'parcel_description' => 'required',
            'logitsic_type' => 'required',
            'weight' => 'required',
            'location' => 'required',
            'total_days' => 'required',
            'deputuer_day' => 'required',
            'arrival_day' => 'required'
        ];
    }
}
