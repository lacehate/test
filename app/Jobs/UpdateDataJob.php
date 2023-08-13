<?php

namespace App\Jobs;

use App\Models\News;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\DataTransferObjects\News\NewsDto;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private NewsDto $dto;
    private string $slug;

    public function __construct(NewsDto $dto, string $slug)
    {
        $this->dto = $dto;
        $this->slug = $slug;
    }

    public function handle()
    {
        return News::where('slug', $this->slug)
            ->update(
            [
                'title' =>  $this->dto->getTitle(),
                'slug' => $this->dto->getSlug(),
                'preview' => $this->dto->getPreview(),
                'news_category_id' => $this->dto->getNewsCategoryId(),
                'content' => $this->dto->getContent(),
                'published_at' =>  $this->dto->getPublishedAt(),
            ]);
    }

    public function failed()
    {
        return 'failed';
    }
}
