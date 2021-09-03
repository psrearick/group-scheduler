<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreEventRequest extends FormRequest
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
            'name'          => ['required', 'string'],
            'description'   => ['sometimes', 'string'],
            'recurring'     => ['required', 'boolean'],
            'start_date'    => ['required', 'date'],
            //            'end_date'      => Rule::requiredIf(function () {
            //                return request('recurring');
            //            }),
            //            'frequency'      => Rule::requiredIf(function () {
            //                return request('recurring');
            //            }),
            'schedule_id'    => ['required'],
        ];
    }
}
