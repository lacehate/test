<?php

namespace App\Http\Resources\News;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**@mixin News */
final class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'title'=> $this->title,
            'slug'=> $this->slug,
            'content' => $this->content,
            'preview' => $this->preview,
            'count' => $this->count,
            'published_at' => $this->published_at ?? '',
            $this->mergeWhen($request->slug, [
                'news_category_title' => $this->news_category_title,
                'news_category_slug' => $this->news_category_slug,
            ]),
        ];
    }
}
