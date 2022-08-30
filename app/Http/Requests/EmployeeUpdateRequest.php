<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeUpdateRequest extends FormRequest
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
            'identity_no' => ['required', 'numeric', 'digits:16', 'min:0'],
            'fullname' => ['required', 'max:255', 'string'],
            'nickname' => ['required', 'max:20', 'string'],
            'no_telp' => [
                'required',
                'digits_between:8,16',
                'min:0',
                'numeric',
            ],
            'birth_place' => ['required', 'max:255', 'string'],
            'birth_date' => ['required', 'date'],
            'fathers_name' => ['required', 'max:255', 'string'],
            'mothers_name' => ['required', 'max:255', 'string'],
            'parents_no_telp' => [
                'required',
                'digits_between:8,16',
                'min:0',
                'numeric',
            ],
            'address' => ['required', 'max:255', 'string'],
            'district_id' => ['nullable', 'exists:districts,id'],
            'province_id' => ['nullable', 'exists:provinces,id'],
            'regency_id' => ['nullable', 'exists:regencies,id'],
            'village_id' => ['nullable', 'exists:villages,id'],
            'codepos' => ['required', 'integer', 'digits:5'],
            'gps_location' => ['nullable', 'max:255', 'string'],
            'siblings_name' => ['required', 'max:255', 'string'],
            'siblings_no_telp' => [
                'required',
                'digits_between:8,16',
                'min:0',
                'numeric',
            ],
            'bpjs' => ['required', 'boolean'],
            'bank_account_no' => ['required', 'min:0', 'numeric'],
            'marital_status' => ['required', 'max:255'],
            'bank_id' => ['required', 'exists:banks,id'],
            'accepted_work_date' => ['required', 'date'],
            'ttd' => ['required', 'max:255', 'string'],
            'religion' => ['required', 'max:255'],
            'gender' => ['required', 'max:255'],
            'driver_license' => ['required', 'max:255', 'string'],
            'level_of_education' => ['required', 'max:255'],
            'major' => ['required', 'max:255', 'string'],
            'image_identity_id' => ['required', 'image', 'max:1024'],
            'image_selfie' => ['required', 'image', 'max:1024'],
            'employee_status_id' => ['nullable', 'exists:employee_statuses,id'],
            'notes' => ['required', 'max:255', 'string'],
        ];
    }
}
