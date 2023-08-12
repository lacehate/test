<?php

namespace App\Http\Requests\News;

use App\DataTransferObjects\News\NewsDto;
use Illuminate\Foundation\Http\FormRequest;

final class NewsRequest extends FormRequest
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
     * @return string[][]
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:128'],
            'slug' => ['required', 'string', 'max:128'],
            'news_category_id' => ['required', 'integer'],
            'preview' => ['required', 'string', ],
            'content' => ['required', 'string'],
            'published_at' => ['nullable', 'string'],
        ];
    }

    /**
     * @return NewsDto
     */
    public function getDto(): NewsDto
    {
        return new NewsDto(
            $this->input('title'),
            $this->input('slug'),
            $this->input('news_category_id'),
            $this->input('preview'),
            $this->input('content'),
            $this->input('published_at'),
        );
    }
}
