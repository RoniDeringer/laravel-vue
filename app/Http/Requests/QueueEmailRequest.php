<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QueueEmailRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'to' => ['required', 'email:rfc,dns', 'max:254'],
            'subject' => ['required', 'string', 'max:150'],
            'message' => ['required', 'string', 'max:5000'],
        ];
    }
}

