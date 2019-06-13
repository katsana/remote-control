<?php

namespace RemoteControl\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAccessRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'content' => ['sometimes', 'min:10'],
        ];
    }
}
