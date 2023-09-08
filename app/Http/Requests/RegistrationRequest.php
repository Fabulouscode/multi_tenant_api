<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class RegistrationRequest extends FormRequest
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
            'email' => ['required', 'email', 'max:255', 'min:2', 'unique:users'],
            'name' => ['required', 'string', 'max:100', 'min:5'],
            'subdomain' => ['required', 'string', 'max:50', 'min:2', 'unique:tenants'],
            'password' => ['required', 'string', 'max:128', Password::defaults()],
            'terms_and_conditions' => ['accepted'],
        ];
    }

    public function validatedData()
    {
        return $this->validated('validated_data', [
            'uuid' => Str::orderedUuid(),
            'email' => $this->email,
            'name' => $this->name,
            'subdomain' => $this->subdomain,
            'password' => $this->password,
        ]);
    }

    public function messages()
    {
        return [
            'email.unique' => 'The submitted email is not allowed',
        ];
    }
}
