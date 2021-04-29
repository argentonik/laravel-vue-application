<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BulletinRequest extends FormRequest
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
            'title' => 'required|min:4|max:64',
            'description' => 'required|min:4|max:512',
            'phone' => 'required|regex:/^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/',
            'country' => 'required|min:2|max:32',
            'email' => 'required|email',
            'valid_to' => 'required|date|after:today|before:+30 days',
            'image' => 'nullable',
            'latitude' => 'nullable|min:-90|max:90',
            'longitude' => 'nullable|min:-180|max:180'
        ];
    }
}
