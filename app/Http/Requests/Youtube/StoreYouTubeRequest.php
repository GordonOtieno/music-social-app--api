<?php

namespace App\Http\Requests\Youtube;

use Illuminate\Foundation\Http\FormRequest;

class StoreYouTubeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'user_id'=>'required',
            'title' => 'required|string',
            'url' => 'required|string'
        ];
    }
}
