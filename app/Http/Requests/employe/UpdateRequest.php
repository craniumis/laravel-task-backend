<?php

namespace App\Http\Requests\employe;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class UpdateRequest extends FormRequest
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
            "first_name" => "required|string|max:250",
            "last_name" => "required|string|max:250",
            "company" => "required|numeric|min:1",
            "email" => "sometimes|nullable|email|max:250|unique:employees,email,".$this->segment(3),
            "phone" => "sometimes|nullable|numeric",
        ];
    }

    public function messages()
    {
        return [
            "company.min" => "Please select company",
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json([
                'message' => "",
                'errors' => $errors
            ], 422)
        );
    }
}
