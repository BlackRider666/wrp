<?php

namespace App\Http\Controllers\API\Organization;

use App\Http\Controllers\Controller;
use App\Repo\StructureUnitRepo;
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
        return new JsonResponse($this->repo->search($data));
    }
}
