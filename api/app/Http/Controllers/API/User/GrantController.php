<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Grant\StoreGrantRequest;
use App\Http\Requests\User\Grant\UpdateGrantRequest;
use App\Repo\GrantRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GrantController extends Controller
{
    /**
     * @var GrantRepo
     */
    private $repo;

    public function __construct(GrantRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $request->only(['user_id']);

        return new JsonResponse($this->repo->search($data));
    }

    /**
     * @param StoreGrantRequest $request
     * @return JsonResponse
     */
    public function store(StoreGrantRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->getKey();

        try {
            $grant = $this->repo->create($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'grant'  =>  $grant,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateGrantRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateGrantRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $grant = $this->repo->update($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'grant'  =>  $grant,
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
            'message'  =>  'Grant deleted!',
        ]);
    }
}
