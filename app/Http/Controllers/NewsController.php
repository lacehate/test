<?php

namespace App\Http\Controllers;

use App\Services\NewsService;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\News\NewsRequest;
use App\Http\Resources\News\NewsResource;
use App\Http\Requests\News\NewsListRequest;
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
     * @param NewsListRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return NewsCategoryResource::collection($this->newsService->list());
    }

    /**
     * @param NewsListRequest $request
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
        $newsCreatedCard = $this->newsService->store($request->getDto());
        if($newsCreatedCard === 'already exists'){
            return response()->json(['status' => 'failed', 'data' => $newsCreatedCard], 200);
        }else{
            return response()->json(['status' => 'success', 'data' => $newsCreatedCard], 200);
        }
    }

    /**
     * Update the specified resource.
     *
     * @param NewsRequest $request
     * @return JsonResponse
     */
    public function update(NewsRequest $request, $slug): JsonResponse
    {
        $this->newsService->update($request->getDto(), $slug);
        return response()->json(['status' => 'successfully updated'], 200);
    }

    /**
     * Update the specified resource.
     *
     * @param NewsRequest $request
     * @return JsonResponse
     */
    public function destroy(NewsDestroyRequest $request): JsonResponse
    {
        $requestData = $request->validated();
        return $this->newsService->delete($requestData['slug']);
    }
}
