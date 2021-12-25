<?php

namespace App\Http\Requests\Dashboard\MyOrder;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
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
            'buyer_id' => 'nullable', 'integer', 'exists:users,id',
            'freelancer_id' => 'nullable', 'integer', 'exists:users,id',
            'service_id' => 'nullable', 'integer', 'exists:services,id',
            'file' => 'required', 'file', 'mimes:zip', 'max:1024',
            'note' => 'required', 'string', 'max:10000',
            'expired' => 'nullable', 'date',
            'order_status_id' => 'nullable', 'integer', 'exists:order_statuses,id'
        ];
    }
}
