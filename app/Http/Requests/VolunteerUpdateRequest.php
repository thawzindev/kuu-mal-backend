<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class VolunteerUpdateRequest extends FormRequest
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
        $id = auth()->id();
        
        return [
            'name' => 'required',
            'phone' => [
                'required', 'numeric',
                    Rule::unique('volunteers')->ignore($id)
            ],
            'address' => 'required',
            'activities'    => 'required'
        ];
    }
}
