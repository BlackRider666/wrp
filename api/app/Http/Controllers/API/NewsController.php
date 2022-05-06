<?php

namespace App\Http\Controllers\API;

use App\Models\News\News;
use BlackParadise\LaravelAdmin\Http\Controllers\SimpleApiController;
use Illuminate\Http\Request;

class NewsController extends SimpleApiController
{
    protected function getModelClass(): string
    {
       return News::class;
    }
}
