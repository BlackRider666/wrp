<?php

namespace App\Http\Controllers\API\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\Unit\StoreUnitRequest;
use App\Http\Requests\Organization\Unit\UpdateUnitRequest;
use App\Models\Organization\Organization;
use App\Models\Organization\StructuralUnit\StructuralUnit;
use App\Repo\StructureUnitRepo;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StructuralUnitController extends Controller
{
    /**
     * @var StructureUnitRepo
     */
    private $repo;

    /**
     * StructuralUnitController constructor.
     * @param StructureUnitRepo $repo
     */
    public function __construct(StructureUnitRepo $repo)
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
        return new JsonResponse(['data' => $this->repo->search($data)]);
    }

    /**
     * @param StoreUnitRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function store(StoreUnitRequest $request): JsonResponse
    {
        $data = $request->validated();
        $this->authorize('create', [StructuralUnit::class, Organization::find($data['organization_id'])]);
        try {
            $unit = $this->repo->create($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 500);
        }

        return new JsonResponse([
            'unit'  =>  $unit,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateUnitRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateUnitRequest $request): JsonResponse
    {
        $data = $request->validated();
        $unit = $this->repo->find($id);
        $this->authorize('update', $unit);

        try {
            $unit = $this->repo->update($unit,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'unit'  =>  $unit,
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $unit = $this->repo->find($id);
        $this->authorize('delete', $unit);

        try {
            $this->repo->delete($unit);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ],500);
        }

        return new JsonResponse([
            'message'  =>  'Unit deleted!',
        ]);
    }
}
