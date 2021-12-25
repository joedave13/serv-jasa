<?php

namespace App\Http\Requests\Dashboard\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'delivery_time' => ['required', 'integer', 'max:100'],
            'revision_limit' => ['required', 'integer', 'max:100'],
            'price' => ['required', 'integer'],
            'note' => ['nullable', 'string', 'max:5000'],
        ];
    }
}
