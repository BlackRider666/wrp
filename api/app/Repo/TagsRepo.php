<?php

namespace App\Repo;

use App\Models\Tag\Tag;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use RuntimeException;

class TagsRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Tag::class;
    }

    /**
     * @param array $data
     * @return array
     */
    public function createMany(array $data): array
    {
        $tags = collect($data);
        $tagsIds = $tags->map( function ($item) {
            return $this->query()->firstOrCreate([
                'name'  =>  $item['name'],
            ])->getKey();
        })->toArray();

        return $tagsIds;
    }
}
