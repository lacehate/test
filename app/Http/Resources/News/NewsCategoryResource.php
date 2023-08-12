<?php

namespace App\Http\Resources\News;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**@mixin NewsCategory */
final class NewsCategoryResource extends JsonResource
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
            'related_news' => NewsResource::collection($this->news)
        ];
    }
}
