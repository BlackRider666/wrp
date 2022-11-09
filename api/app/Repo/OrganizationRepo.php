<?php


namespace App\Repo;


use App\Models\Organization\Organization;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class OrganizationRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Organization::class;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        return $this->query()->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data)
    {
        if (!$organization = $this->query()->create($data)) {
            throw new RuntimeException('Error on creating organization!',500);
        }

        return $organization;
    }
}
