<?php


namespace App\Repo;


use App\Models\Organization\StructuralUnit\StructuralUnit;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use RuntimeException;

class StructureUnitRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return StructuralUnit::class;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        $query = $this->query();
        if (array_key_exists('organization_id',$data)) {
            $query->where('organization_id',$data['organization_id']);
        }
        return $query->paginate($perPage);
    }

    public function create(array $data)
    {
        if (!$unit = $this->query()->create($data)) {
            throw new RuntimeException('Error on creating unit!',500);
        }

        return $unit;
    }
}
