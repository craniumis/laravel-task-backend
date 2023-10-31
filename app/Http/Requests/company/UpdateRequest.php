<?php

namespace App\Http\Requests\company;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
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
            "name" => "required|string|max:250",
            "email" => "sometimes|nullable|email|max:250|unique:companies,email,".$this->segment(3),
            "logo" => "sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=100,min_height=100",
        ];
    }

    public function messages():array
    {
        return [
            "logo.dimensions" => "Image dimension min width:100px and min height:100px",
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
