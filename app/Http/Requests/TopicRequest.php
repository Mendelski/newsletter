<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TopicRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
            'slug' => 'required|unique:topics',
            'description' => 'nullable',
            'active_at' => 'nullable|date',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
