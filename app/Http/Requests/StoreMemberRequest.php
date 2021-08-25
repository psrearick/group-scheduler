<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
            'name'             => ['required', 'string', 'max:255'],
            'email'            => ['sometimes', 'nullable', 'string', 'email', 'max:255', 'unique:users'],
            'username'         => ['sometimes', 'unique:users'],
            'phone_number'     => ['sometimes'],
            'groupme_username' => ['sometimes'],
        ];
    }
}
