<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Project\SearchProjectRequest;
use App\Http\Requests\User\Project\StoreProjectRequest;
use App\Http\Requests\User\Project\UpdateProjectRequest;
use App\Repo\ProjectRepo;
use Exception;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    /**
     * @var ProjectRepo
     */
    private $repo;

    public function __construct(ProjectRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param SearchProjectRequest $request
     * @return JsonResponse
     */
    public function index(SearchProjectRequest $request): JsonResponse
    {
        $data = $request->validated();

        return new JsonResponse($this->repo->search($data));
    }

    /**
     * @param StoreProjectRequest $request
     * @return JsonResponse
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->getKey();

        try {
            $project = $this->repo->create($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'project'  =>  $project,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateProjectRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateProjectRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $project = $this->repo->update($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'project'  =>  $project,
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
            'message'  =>  'Project deleted!',
        ]);
    }
}
