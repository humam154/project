<?php

namespace App\Http\Requests;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SalaryCreateRequest extends FormRequest
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
            'salary' => ['required', 'numeric', 'min:0'],
            'grade_id' => ['required', 'exists:salary_grades,id']
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Throw new ValidationException($validator, Response::Validation([], $validator->errors()));
    }
}
