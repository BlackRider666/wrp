<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreAuthorRequest;
use App\Models\User\User;
use App\Repo\UserRepo;
use BlackParadise\LaravelAdmin\Core\AbstractRepo;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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

    public function store(StoreAuthorRequest $request): JsonResponse
    {
        $data = $request->validated();
        $role = env('APP_DEFAULT_ROLE');
        $data['password'] = Hash::make(Str::password());
        try {
            $user = $this->repo->create($data,$role);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], !is_int($e->getCode()) || $e->getCode() === 0 ?500:$e->getCode());
        }

        return new JsonResponse([
            'user' => $user,
        ]);
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
                    'socialLinks',
                    'city',
                    'country',
                    'organization',
                    'articles'
                    ]),
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function statistics(int $id): JsonResponse
    {
        $statistic = $this->repo->findPercentageOccupancy($id);
        return new JsonResponse($statistic);
    }
}
