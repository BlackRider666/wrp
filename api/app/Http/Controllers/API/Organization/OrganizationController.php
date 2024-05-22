<?php

namespace App\Http\Controllers\API\Organization;

use App\Http\Controllers\Controller;
use App\Http\Requests\Organization\UpdateOrganizationRequest;
use App\Http\Resources\Organization\BaseOrganizationResource;
use App\Models\Organization\Organization;
use App\Repo\OrganizationRepo;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizationController extends Controller
{
    /**
     * @var OrganizationRepo
     */
    private $repo;

    public function __construct(OrganizationRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $request->only('perPage');
        $organizations = $this->repo->search($data);

        return BaseOrganizationResource::collection($organizations);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        if (!$organization = $this->repo->findWith($id, ['country','city','staff','user', 'units', 'units.child',])) {
            return new JsonResponse([
                'message'   =>  'Not Found!'
            ],404);
        }
        return new JsonResponse([
            'organization'   =>  $organization,
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function edit(int $id): JsonResponse
    {
        $this->authorize('update',Organization::find($id));

        if (!$organization = $this->repo->findWith($id, ['country','city', 'units', 'units.child','staff'])) {
            return new JsonResponse([
                'message'   =>  'Not Found!'
            ],404);
        }

        return new JsonResponse([
            'organization'   =>  $organization,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateOrganizationRequest $request
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateOrganizationRequest $request): JsonResponse
    {
        $organization = $this->repo->find($id);
        $this->authorize('update',$organization);

        if (!$organization = $this->repo->updateStaff($organization, $request->validated())) {
            return new JsonResponse([
                'message'   =>  'Not Found!'
            ],404);
        }

        return new JsonResponse([
            'organization'   =>  $organization,
        ]);
    }
}
