<?php

namespace App\Http\Requests\Duel;

use Illuminate\Foundation\Http\FormRequest;

class CreateGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'chat' => ['required', 'string', 'max:100']
        ];
    }
}
