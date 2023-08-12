<?php

namespace App\Http\Requests\News;

use Illuminate\Foundation\Http\FormRequest;

class NewsDestroyRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
      if (auth()->user() && auth()->user()->hasRole('admin')) {
        return true;
    }
        return response()->json(['message' => 'Unauthorized'], 403);
    }

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
