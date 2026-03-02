<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
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
            'date' => 'required|string',
            'permit_type' => 'required|in:full,temporary',
            'note' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'start_time' => 'nullable|required_if:permit_type,temporary|date_format:H:i',
            'end_time' => 'nullable|required_if:permit_type,temporary|date_format:H:i|after:start_time',
        ];
    }
}
