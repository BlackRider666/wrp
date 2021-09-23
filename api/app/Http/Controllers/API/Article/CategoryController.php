<?php

namespace App\Http\Controllers\API\Article;

use App\Http\Controllers\Controller;
use App\Models\Article\Category\Category;
use BlackParadise\LaravelAdmin\Http\Controllers\SimpleApiController;
use Illuminate\Http\Request;

class CategoryController extends SimpleApiController
{
    protected function getModelClass(): string
    {
        return Category::class;
    }
}
