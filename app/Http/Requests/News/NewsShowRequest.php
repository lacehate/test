<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class NewsShowRequest extends FormRequest
{


    /**
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge(
            [
                'slug' => $this->route('slug'),
            ]
        );
    }

    /**
     * @return array[]
     */
    public function rules(): array
    {
        return [
            'slug' => ['bail', 'required', 'string', 'max:512'],
        ];
    }
}
