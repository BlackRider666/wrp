<?php

namespace App\Http\Controllers\API\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Models\Article\Article;
use App\Repo\ArticleRepo;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
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
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $request->all();

        return new JsonResponse($this->repo->search($data));
    }

    /**
     * @param CreateArticleRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateArticleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->authorize('create', Article::class);
        $user = $request->user();
        try {
            $article = $this->repo->create($data);
            if ((array_search($user->getKey(), $data['authors'], true)) !== false) {
                $article->authors()->where('user_id', $user->getKey())->update(['approved' => true]);
            }
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'article'  =>  $article,
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $article = $this->repo->findWithCategory($id);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'article'  =>  $article,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateArticleRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateArticleRequest $request): JsonResponse
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

        return new JsonResponse([
            'article'  =>  $article,
        ]);
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
