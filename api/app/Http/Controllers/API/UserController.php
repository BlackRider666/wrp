<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Repo\UserRepo;
use BlackParadise\LaravelAdmin\Core\AbstractRepo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @var Model
     */
    protected $repo;

    /**
     * CoreRepository constructor.
     * @param UserRepo $repo
     */
    public function __construct(UserRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse($this->repo->search($request->all()));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function authors(Request $request): JsonResponse
    {
        return new JsonResponse($this->repo->searchAuthors($request->all()));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        return new JsonResponse([
            'user' => $this->repo->findWith(
                $id,
                [
                    'works',
                    'grants',
                    'projects',
                    'articles',
                    'articles.category',
                    ]),
        ]);
    }
}
