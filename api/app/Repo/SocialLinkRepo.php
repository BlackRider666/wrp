<?php

namespace App\Repo;

use App\Models\User\SocialLink\SocialLink;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class SocialLinkRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return SocialLink::class;
    }

    public function search(array $data)
    {
        $query = $this->query();
        if (array_key_exists('user_id', $data)) {
            $query->where('user_id', $data['user_id']);
        }

        return $query->get();
    }

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function store(array $data)
    {
        if (!$link = $this->query()->create($data)) {
            throw new RuntimeException('Error on creating link!',500);
        }

        return $link;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model
    {
        if (!$link = $this->find($id)) {
            throw new RuntimeException('Link not found',404);
        }
        if (!$link->update($data)) {
            throw new RuntimeException('Error on updating link!',500);
        }
        $link->fresh();

        return $link;
    }

    /**
     * @throws RuntimeException|Exception
     */
    public function delete(int $id): void
    {
        if (!$link = $this->find($id)) {
            throw new RuntimeException('Link not found',404);
        }
        if (!$link->delete()) {
            throw new RuntimeException('Error on destroying link!',500);
        }
    }
}
