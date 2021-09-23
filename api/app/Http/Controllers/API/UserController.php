<?php

namespace App\Http\Controllers\API;

use App\Models\User\User;
use BlackParadise\LaravelAdmin\Http\Controllers\SimpleApiController;

class UserController extends SimpleApiController
{
    protected function getModelClass(): string
    {
        return User::class;
    }
}
