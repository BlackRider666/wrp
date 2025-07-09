<?php

namespace App\Http\Controllers\API\Article;

use App\Http\Controllers\Controller;
use App\Http\Resources\Article\SimpleDirectionResource;
use App\Service\Article\DirectionService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class DirectionController extends Controller
{
    public function __construct(
        private DirectionService $directionService
    )
    {}

    /**
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $data = $this->directionService->getListForSelect();

        return SimpleDirectionResource::collection($data);
    }
}
