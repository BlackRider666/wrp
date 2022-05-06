<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Organizer\Organizer;
use BlackParadise\LaravelAdmin\Http\Controllers\SimpleApiController;
use Illuminate\Http\Request;

class OrganizerController extends SimpleApiController
{
    protected function getModelClass(): string
    {
        return Organizer::class;
    }
}
