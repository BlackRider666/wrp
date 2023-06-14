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
        $query = $this->query();
        $query->with(['country','city']);

        return $query->paginate($perPage);
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

    public function findWith(int $id, array $with)
    {
        $query = $this->query();

        return $query->with($with)->find($id);
    }

    /**
     * @param Organization $organization
     * @param array $data
     * @return Organization
     */
    public function updateStaff(Organization $organization, array $data): Organization
    {
        if (!$organization->staff()->sync($data['users'])) {
            throw new RuntimeException('Error on updating staff organization!',500);
        }

        if (!$organization->update($data)) {
            throw new RuntimeException('Error on updating rector organization!',500);
        }

        $organization->fresh();
        $organization->load(['country','city', 'units', 'units.child','staff']);

        return $organization;
    }
}
