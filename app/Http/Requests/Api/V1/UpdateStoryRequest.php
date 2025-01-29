<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStoryRequest extends FormRequest
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
            'state_id' => 'nullable|integer',
            'title' => 'nullable|string',
            'body' => 'nullable|string',
            'teller' => 'nullable|string',
            'keywords' => 'nullable|string',
            'tags' => 'nullable|nullable',
            'written_at' => 'nullable|date',
            'visible' => 'nullable|boolean'
        ];
    }
}
