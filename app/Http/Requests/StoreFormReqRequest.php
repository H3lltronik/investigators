<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFormReqRequest extends FormRequest
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
            'addresses' => 'required',
            'addresses.*.name' => 'required|max:255',
            'addresses.*.city' => 'required|max:255',
            'addresses.*.address' => 'required|max:255',
            'addresses.*.phone' => 'required|max:255',
            'addresses.*.hasExtendedQuestions' => 'required',
            'addresses.*.extendedQuestions' => 'required',
        ];
    }
}
