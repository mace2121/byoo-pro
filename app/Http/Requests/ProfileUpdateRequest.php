<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => [
                'required',
                'string',
                'max:50',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'bio' => ['nullable', 'string', 'max:1000'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'bg_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'theme_type' => ['nullable', 'string', 'in:preset,custom'],
            'bg_type' => ['nullable', 'string', 'in:color,gradient,image'],
            'bg_color' => ['nullable', 'string', 'max:50'],
            'bg_blur' => ['nullable', 'integer', 'min:0', 'max:100'],
            'bg_overlay' => ['nullable', 'integer', 'min:0', 'max:100'],
            'text_color' => ['nullable', 'string', 'max:50'],
            'button_color' => ['nullable', 'string', 'max:50'],
            'button_text_color' => ['nullable', 'string', 'max:50'],
            'button_style' => ['nullable', 'string', 'in:rounded,pill,square,soft'],
            'font_family' => ['nullable', 'string', 'in:sans,serif,mono,poppins,inter,outfit,roboto,montserrat,playfair'],
            'custom_css' => ['nullable', 'string', 'max:5000'],
            'custom_domain' => [
                'nullable',
                'string',
                'max:255',
                'regex:/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]$/i',
                Rule::unique('profiles')->ignore($this->user()->profile?->id),
            ],
        ];
    }
}
