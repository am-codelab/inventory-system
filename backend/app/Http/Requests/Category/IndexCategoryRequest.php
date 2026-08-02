<?php

namespace App\Http\Requests\Category;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexCategoryRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'search' => [
                'nullable',
                'string',
                'max:100',
            ],

            'active' => [
                'nullable',
                'boolean',
            ],

            'sort' => [
                'nullable',
                Rule::in([
                    'id',
                    'name',
                    'created_at',
                ]),
            ],

            'direction' => [
                'nullable',
                Rule::in([
                    'asc',
                    'desc',
                ]),
            ],

            'per_page' => [
                'nullable',
                Rule::in([
                    5,
                    10,
                    15,
                    25,
                    50,
                ]),
            ],

        ];
    }
}
