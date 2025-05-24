<?php

namespace App\Http\Requests;

use App\Rules\NoProfanity;
use Illuminate\Foundation\Http\FormRequest;

class StoreCandidateRequest extends FormRequest
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
            'name' => 'required| min:5',
            'email' => 'required|email|unique:candidates,email',
            'birth_date' => 'required|date|before:18 years ago',
            'avatar_path' => 'nullable|image|max:2048',
            'cv_path' => 'required|mimetypes:application/pdf|max:5120',
            'bio' => ['nullable', 'max:1000', new NoProfanity()],
        ];
    }
}
