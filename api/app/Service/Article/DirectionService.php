<?php

namespace App\Service\Article;

use App\Repo\Article\DirectionRepo;
use Illuminate\Support\Collection;

class DirectionService
{
    private DirectionRepo $repo;

    public function __construct()
    {
        $this->repo = new DirectionRepo();
    }

    /**
     * @return Collection
     */
    public function getListForSelect(): Collection
    {
        return $this->repo->getSimpleList();
    }
}
