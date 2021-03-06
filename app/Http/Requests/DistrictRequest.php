<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
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
        $district = $this->route('district');
        return [
            'district_name' => 'required|unique:districts,district_name,' . $district .',district_id',
            'division_name' => 'required',
            'description' => 'required',
        ];
    }
}
