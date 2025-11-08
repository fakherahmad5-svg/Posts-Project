<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'name' => 'required',
            'phone' => 'min:10|max:10|unique:users,phone',
            'address' => 'min:4|max:100',
            'gender' => 'optional|in:male,female',
            'profile_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
