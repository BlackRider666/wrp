<?php


namespace App\Repo;


use App\Models\Country\City\City;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CityRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return City::class;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        $query = $this->query();

        if (array_key_exists('country_id',$data)) {
            $query->where('country_id', $data['country_id']);
        }

        return $query->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function forSelect(array $data): Collection
    {
        $query = $this->query();

        if (array_key_exists('country_id',$data)) {
            $query->where('country_id', $data['country_id']);
        }

        return $query->get(['name','id']);
    }
}
