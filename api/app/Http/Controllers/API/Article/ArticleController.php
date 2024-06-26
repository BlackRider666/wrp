<?php

namespace App\Http\Controllers\API\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\SearchArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Http\Resources\Article\ArticleResource;
use App\Http\Resources\Article\SimpleArticleResource;
use App\Models\Article\Article;
use App\Repo\ArticleRepo;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * @var ArticleRepo
     */
    private $repo;

    public function __construct(ArticleRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param SearchArticleRequest $request
     * @return AnonymousResourceCollection
     */
    public function index(SearchArticleRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $articles = $this->repo->search($data);
        return SimpleArticleResource::collection($articles);
    }

    /**
     * @param CreateArticleRequest $request
     * @return SimpleArticleResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateArticleRequest $request): JsonResponse|SimpleArticleResource
    {
        $data = $request->validated();
        $this->authorize('create', Article::class);
        $user = $request->user();
        try {
            $article = $this->repo->create($data);
            Log::info($data['authors']);
            if ((array_search($user->getKey(), $data['authors'])) !== false) {
                Log::info('Set Update aprroved');
                $article->authors()->where('user_id', $user->getKey())->update(['approved' => 1]);
            }
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 500);
        }

        return new SimpleArticleResource($article);
    }

    /**
     * @param int $id
     * @return ArticleResource|JsonResponse
     */
    public function show(int $id): ArticleResource|JsonResponse
    {
        try {
            $article = $this->repo->findWithCategory($id);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new ArticleResource($article);
    }

    /**
     * @param int $id
     * @param UpdateArticleRequest $request
     * @return SimpleArticleResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateArticleRequest $request): JsonResponse|SimpleArticleResource
    {
        $data = $request->validated();
        $article = $this->repo->find($id);
        $this->authorize('update', $article);

        try {
            $article = $this->repo->update($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new SimpleArticleResource($article);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $article = $this->repo->find($id);
        $this->authorize('delete', $article);

        try {
            $this->repo->delete($id);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ],500);
        }

        return new JsonResponse([
            'message'  =>  'Article deleted!',
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function approveAuthor(int $id): JsonResponse
    {
        try {
            $this->repo->approveAuthor($id, auth()->user()->getKey());
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ],500);
        }

        return new JsonResponse([
            'message'  =>  'Approved!',
        ]);
    }
}
