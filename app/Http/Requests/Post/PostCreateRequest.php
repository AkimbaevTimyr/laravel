<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class PostCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:64', 'unique:posts'],
            'description' => ['required', 'max:500'],
            'file' => ['file', 'mimes:jpg,png', 'max:1024']
        ];
    }
}