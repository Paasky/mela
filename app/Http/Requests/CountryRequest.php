<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
{
    public function authorize(): bool
    {
        // todo create CountryPolicy and use it here or in CountryController actions
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['string', 'regex:/[A-Z]{2}/', 'unique:countries', 'required'],
        ];
    }
}
