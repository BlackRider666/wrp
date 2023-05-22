<?php

namespace App\Http\Controllers\API\Organization;

use App\Http\Controllers\Controller;
use App\Repo\OrganizationRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse($this->repo->search($request->all()));
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        if (!$organization = $this->repo->findWith($id)) {
            return new JsonResponse([
                'message'   =>  'Not Found!'
            ],404);
        }
        return new JsonResponse([
            'organization'   =>  $organization,
        ]);
    }
}
