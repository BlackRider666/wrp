<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Organizer\BaseOrganizerResource;
use App\Models\Organizer\Organizer;
use App\Repo\OrganizerRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizerController extends Controller
{
    private OrganizerRepo $repo;

    public function __construct(OrganizerRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $data = $request->only(['perPage', 'page']);
        $organizers = $this->repo->search($data);

        return BaseOrganizerResource::collection($organizers);

    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        if (!$organizer = $this->repo->find($id)) {
            return new JsonResponse([
                'message'   =>  'Not Found!'
            ],404);
        }
        return new JsonResponse([
            'organizer'   =>  $organizer,
        ]);
    }
}
