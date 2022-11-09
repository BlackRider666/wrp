<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Organizer\Organizer;
use BlackParadise\LaravelAdmin\Http\Controllers\SimpleApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrganizerController extends SimpleApiController
{
    protected function getModelClass(): string
    {
        return Organizer::class;
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
