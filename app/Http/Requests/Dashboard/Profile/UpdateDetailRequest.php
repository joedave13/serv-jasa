<?php

namespace App\Http\Requests\Dashboard\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateDetailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'photo' => ['nullable', 'image', 'max:1024'],
            'role' => ['nullable', 'string', 'max:100'],
            'contact_number' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/', 'max:15'],
            'biography' => ['nullable', 'string', 'max:5000']
        ];
    }
}
