<?php

namespace App\Services;

use App\Models\News;
use App\Jobs\StoreDataJob;
use App\Jobs\UpdateDataJob;
use App\Models\NewsCategory;
use App\DataTransferObjects\News\NewsDto;
use Illuminate\Database\Eloquent\Collection;
use App\DataTransferObjects\News\NewsListDto;

final class NewsService
{
    /**
     * @param NewsListDto $dto
     * @return Collection
     */
    public function list(): Collection
    {
        return NewsCategory::with(
            [
                'news' => function ($query){$query->whereNotNull('news.published_at')->orderByDesc('news.published_at');
                },
            ])
            ->get();
    }

    /**
     * @param NewsListDto $dto
     * @return Collection
     */
    public function listTop(): Collection
    {
        return News::select(
            [
                'news.title',
                'news.content',
                'news.slug',
                'news.published_at',
                'news.preview',
                'news.count',
            ])
            ->whereNotNull('news.published_at')
            ->orderByDesc('news.count')
            ->limit(10)
            ->get();
    }

    /**
     * @param string $slug
     * @return News|null
     */
    public function show(string $slug): ?News
    {
        $newsCardCount = News::where('slug', $slug)->firstOrFail();
        $newsCardCount->increment('count');

        return News::select(
            [
                'news.title',
                'news.content',
                'news.slug',
                'news.published_at',
                'news.preview',
                'news.count',
                'news_categories.slug as news_category_slug',
                'news_categories.title as news_category_title',
            ])
            ->leftJoin('news_categories', 'news.news_category_id', '=', 'news_categories.id')
            ->where('news.slug', $slug)
            ->whereNotNull('news.published_at')
            ->firstOrFail();
    }

    /**
     * @param NewsDto $dto
     * @return String|Array
     */
    public function store(NewsDto $dto): String|array
    {
        $newsCardExist = News::where('slug', $dto->getSlug())
                            ->orWhere('title', $dto->getTitle())
                            ->first();
        if($newsCardExist){
            return ['status' => 'already exists', 'data'=> $newsCardExist];
        }
        else{
            StoreDataJob::dispatch($dto);
            return ['status' => 'data processing'];
        }
    }

    /**
     * @param NewsDto $dto
     * @return String|Array
     */
    public function update(NewsDto $dto, $slug): String|array
    {
        $newsCardExist = News::where('slug', $slug)
                            ->first();
        if($newsCardExist){
            UpdateDataJob::dispatch($dto, $slug);
            return ['status' => 'successfully updated'];
        }
        else{
            return ['status' => 'non existing record'];
        }
    }

    /**
     * @param string $slug
     * @return String|Array
     */
    public function delete(string $slug): String|Array
    {
        $newsCardExist = News::where('slug', $slug)->first();
        if($newsCardExist){
            News::destroy($newsCardExist->id);
            return ['status' => 'successfully deleted'];
        }
        else{
            return ['status' => 'non existing record'];
        }
    }
}


