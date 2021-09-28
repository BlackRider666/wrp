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
}
