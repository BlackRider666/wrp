<?php

namespace App\Repo;

use App\Models\Organizer\Organizer;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class OrganizerRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Organizer::class;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator|Builder[]|Collection|Model[]
     */
    public function search(array $data): array|Collection|LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        $query = $this->query();
        if ((int)$perPage !== -1 ) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }
}
