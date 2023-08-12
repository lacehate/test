<?php

namespace App\Services;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;
use App\DataTransferObjects\News\NewsDto;
use Illuminate\Database\Eloquent\Builder;
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
                'news' => function ($query){$query->whereNotNull('news.published_at')->orderByDesc('news.count');
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

        $newsCard = News::select(
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

        return $newsCard;
    }

    /**
     * @param NewsDto $dto
     * @return Builder|Model|String
     */
    public function store(NewsDto $dto): Builder|Model|String
    {
        $newsCardExist = News::where('slug', $dto->getSlug())
                            ->orWhere('title', $dto->getTitle())
                            ->first();

        if($newsCardExist){
            return 'already exists';
        }
        else{
            return News::query()
                ->create(
            [
                'title' => $dto->getTitle(),
                'slug' => $dto->getSlug(),
                'preview' => $dto->getPreview(),
                'news_category_id' => $dto->getNewsCategoryId(),
                'content' => $dto->getContent(),
                'published_at' =>  $dto->getPublishedAt(),
            ]);
        }
    }

    /**
     * @param NewsDto $dto
     * @return JsonResponse
     */
    public function update(NewsDto $dto, $slug): JsonResponse
    {
        $newsCardExist = News::where('slug', $slug)->first();
        if($newsCardExist){
            News::where('slug', $slug)
                ->update(
                [
                    'title' =>  $dto->getTitle(),
                    'slug' => $dto->getSlug(),
                    'preview' => $dto->getPreview(),
                    'news_category_id' => $dto->getNewsCategoryId(),
                    'content' => $dto->getContent(),
                    'published_at' =>  $dto->getPublishedAt(),
                ]);
            return response()->json(['status' => 'successfully update'], 200);
        }
        else{
            return response()->json(['status' => 'non existing record'], 200);
        }
    }

    /**
     * @param string $slug
     * @return JsonResponse

     */
    public function delete(string $slug): JsonResponse
    {
        $newsCardExist = News::where('slug', $slug)->first();
        if($newsCardExist){
            News::destroy($newsCardExist->id);
            return response()->json(['status' => 'successfully deleted'], 200);
        }
        else{
            return response()->json(['status' => 'non existing record'], 200);
        }
    }
}


