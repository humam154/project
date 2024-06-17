<?php

namespace App\Http\Requests;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class EmployeeCreateRequest extends FormRequest
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
            'first_name' => ['string','required', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'last_name' => ['string','required', 'min:2', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'email' => ['email', 'required'],
            'phone' => [
                'required',
                'string',
                'regex:/^\+?[0-9\s\-\(\)]+$/',
                'min:10',
                'max:15',
            ],
            'employee_of_the_month' => ['nullable', 'integer', 'min:0','max:12'],
            'salary_id' => ['required'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Throw new ValidationException($validator, Response::Validation([], $validator->errors()));
    }
}
