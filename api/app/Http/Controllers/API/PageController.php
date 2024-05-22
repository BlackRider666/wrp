<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pages\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function contacts()
    {
        return new JsonResponse([
            'page' => Page::where('key','contacts')->first(),
        ]);
    }

    public function rules()
    {
        return new JsonResponse([
            'page' => Page::where('key','rules')->first(),
        ]);

    }
}
