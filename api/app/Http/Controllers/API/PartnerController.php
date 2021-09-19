<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Partner\Partner;
use BlackParadise\LaravelAdmin\Http\Controllers\SimpleApiController;
use Illuminate\Http\Request;

class PartnerController extends SimpleApiController
{
    protected function getModelClass(): string
    {
        return Partner::class;
    }
}
