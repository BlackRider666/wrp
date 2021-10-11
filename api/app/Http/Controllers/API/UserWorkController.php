<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Work\CreateWorkRequest;
use App\Http\Requests\User\Work\UpdateWorkRequest;
use App\Repo\WorkRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserWorkController extends Controller
{
    /**
     * @var WorkRepo
     */
    private $repo;

    public function __construct(WorkRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $id = $request->user()->getKey();

        return new JsonResponse($this->repo->getByUserID($id));
    }

    /**
     * @param CreateWorkRequest $request
     * @return JsonResponse
     */
    public function create(CreateWorkRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->getKey();

        try {
            $work = $this->repo->create($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 500);
        }

        return new JsonResponse([
            'work'  =>  $work,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateWorkRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateWorkRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $work = $this->repo->update($id, $data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'work' => $work,
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
            ], $e->getCode());
        }

        return new JsonResponse([
            'message' => 'Success',
        ]);
    }
}
