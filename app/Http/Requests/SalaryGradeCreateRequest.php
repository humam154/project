<?php

namespace App\Http\Requests;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class SalaryGradeCreateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'letter' => ['required', 'string', 'size:1', 'alpha', 'in:A,B,C,D,E,F,G,H,I,J,K,L,M,N,O,P,Q,R,S,T,U,V,W,X,Y,Z'],
            'description' => ['required', 'string', 'min:2', 'max:255'],
            'basic_salary' => ['required', 'numeric'],

        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Throw new ValidationException($validator, Response::Validation([], $validator->errors()));
    }
}
