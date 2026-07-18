<?php

namespace Fartex\Strat\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MigrationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'per_page' => [
                'nullable',
                'integer',
            ],
        ];
    }
}
