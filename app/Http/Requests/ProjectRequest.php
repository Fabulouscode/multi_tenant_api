<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class ProjectRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:100', 'min:5', 'unique:projects'],
        ];
    }

    public function validatedData()
    {
        return $this->validated('validated_data', [
            'uuid' => Str::orderedUuid(),
            'name' => $this->name,
        ]);
    }

    public function messages()
    {
        return [
            'name.unique' => 'The submitted project name already exists',
        ];
    }
}
