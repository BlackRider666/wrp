<?php

namespace App\Repo\Article;

use App\Models\Article\Direction\Direction;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Support\Collection;

class DirectionRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Direction::class;
    }

    public function getSimpleList(): Collection
    {
        return $this->query()->get(['id','name']);
    }
}
