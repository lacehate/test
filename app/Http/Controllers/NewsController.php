<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\News\NewsRequest;
use App\Http\Resources\News\NewsResource;
use App\Http\Requests\News\NewsShowRequest;
use App\Http\Requests\News\NewsDestroyRequest;
use App\Http\Resources\News\NewsCategoryResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class NewsController extends Controller
{
    private NewsService $newsService;

    public function __construct(NewsService $newsService)
    {
        $this->newsService = $newsService;
    }

    /**
     * List all by category.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return NewsCategoryResource::collection($this->newsService->list());
    }

    /**
     * List most viewed limit 10.
     *
     * @return AnonymousResourceCollection
     */
    public function mostViewed(): AnonymousResourceCollection
    {
        return NewsResource::collection($this->newsService->listTop());
    }

    /**
     * Display the specified resource.
     *
     * @param NewsShowRequest $request
     * @return NewsResource
     */
    public function show(NewsShowRequest $request): NewsResource
    {
        $requestData = $request->validated();
        return NewsResource::make($this->newsService->show($requestData['slug']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NewsRequest $request
     */
    public function store(NewsRequest $request)
    {
        $dto = $request->getDto();
        return response()->json($this->newsService->store($dto));
    }

    /**
     * Update the specified resource.
     *
     * @param NewsRequest $request
     * @return JsonResponse
     */
    public function update(NewsRequest $request, $slug): JsonResponse
    {
        $dto = $request->getDto();
        return response()->json($this->newsService->update($dto, $slug));
    }

    /**
     * Delete the specified resource.
     *
     * @param NewsDestroyRequest $request
     * @return JsonResponse
     */
    public function destroy(NewsDestroyRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        return response()->json($this->newsService->delete($requestData['slug']));
        ;
    }
}
