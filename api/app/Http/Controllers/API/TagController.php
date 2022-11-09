<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Repo\TagsRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    private TagsRepo $repo;

    public function __construct(TagsRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse($this->repo->all());
    }
}
