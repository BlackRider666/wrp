<?php


namespace App\Repo;


use App\Models\Country\Country;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CountryRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Country::class;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        $query = $this->query();
        return $query->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Collection
     */
    public function forSelect(array $data): Collection
    {
        return $this->query()->get(['name','id']);
    }
}
