<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Partner\Partner;
use BlackParadise\LaravelAdmin\Http\Controllers\SimpleApiController;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends SimpleApiController
{
    protected function getModelClass(): string
    {
        return Partner::class;
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        if (!$partner = $this->repo->find($id)) {
            return new JsonResponse([
                'message'   =>  'Not Found!'
            ],404);
        }
        return new JsonResponse([
            'partner'   =>  $partner,
        ]);
    }
}
