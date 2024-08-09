<?php

namespace App\Http\Requests;

use App\Http\Responses\Response;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class DistributeIncentiveRequest extends FormRequest
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
            'incentive_block' => 'required|numeric',
            'incentives' => 'required|array',
            'incentives.*.employee_id' => 'required|exists:employees,id',
            'incentives.*.points' => 'required|numeric|max:150',
            'incentives.*.share_id' => 'required|exists:incentive_shares,id',
            'incentives.*.note' => 'required|string',
            'incentives.*.regulations' => 'nullable|array',
            'incentives.*.regulations.*.id' => 'nullable|exists:regulations,id',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        Throw new ValidationException($validator, Response::Validation([], $validator->errors()));
    }
}
