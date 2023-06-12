<?php


namespace App\Repo;


use App\Models\Organization\StructuralUnit\StructuralUnit;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class StructureUnitRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return StructuralUnit::class;
    }

    /**
     * @param array $data
     * @return Builder[]|\Illuminate\Database\Eloquent\Collection|Model[]
     */
    public function search(array $data)
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        $query = $this->query();
        if (array_key_exists('organization_id',$data)) {
            $query->where('organization_id',$data['organization_id']);
        }
        return $query->get();
    }

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data)
    {
        if (!$unit = $this->query()->create($data)) {
            throw new RuntimeException('Error on creating unit!',500);
        }
        $unit->load('child');
        return $unit;
    }

    /**
     * @param Model $unit
     * @param array $data
     * @return Model
     */
    public function update(Model $unit, array $data): Model
    {
        if (!$unit->update($data)) {
            throw new RuntimeException('Error on updating unit!',500);
        }

        $unit->fresh();
        $unit->load('child');
        return $unit;
    }

    /**
     * @param Model $unit
     * @return void
     * @throws Exception
     */
    public function delete(Model $unit): void
    {
        foreach ($unit->child as $child) {
                $this->delete($child);
        }
        if (!$unit->delete()) {
            throw new RuntimeException('Error on deleting unit!',500);
        }
    }
}
