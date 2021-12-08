<?php

namespace App\Http\Controllers\API\Article;

use App\Http\Controllers\Controller;
use App\Http\Requests\Article\CreateArticleRequest;
use App\Http\Requests\Article\UpdateArticleRequest;
use App\Repo\ArticleRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     */
    public function store(CreateArticleRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $article = $this->repo->create($data);
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
                'code'    => $e->getCode(),
            ], 500);
        }

        return new JsonResponse([
            'article'  =>  $article,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateArticleRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateArticleRequest $request): JsonResponse
    {
        $data = $request->validated();

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
     */
    public function destroy(int $id): JsonResponse
    {
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
}
