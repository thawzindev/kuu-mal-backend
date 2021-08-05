<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VolunteerRequest extends FormRequest
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
            'name'  => 'required',
            'phone' => 'required|numeric',
            'address'   => 'required|max:300',
            'activities'   => 'required|max:300',
            'password' => 'nullable|confirmed',
            'state_id' => 'required',
            'township_id' => 'required',
        ];
    }
}
