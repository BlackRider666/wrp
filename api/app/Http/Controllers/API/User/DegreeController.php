<?php

namespace App\Http\Controllers\API\User;

use App\Enum\User\DegreeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class DegreeController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return new JsonResponse([
            'degrees' => DegreeEnum::cases(),
        ]);
    }
}
