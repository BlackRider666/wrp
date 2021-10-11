<?php


namespace App\Repo;


use App\Models\Organization\Organization;
use App\Models\User\Work\Work;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class WorkRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Work::class;
    }

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data)
    {
        $organizationRepo = new OrganizationRepo();
        $structureUnitRepo = new StructureUnitRepo();
        if ($data['organization']['id'] === 'new') {
            $organization = $organizationRepo->create([
                'name' => $data['organization']['name'],
            ]);
            $structureUnit = $structureUnitRepo->create([
                'name' => $data['structure_unit']['name'],
                'organization_id' => $organization->getKey(),
            ]);
            $data['structure_unit']['id'] = $structureUnit->getKey();
        }
        if ($data['structure_unit']['id'] === 'new') {
            $structureUnit = $structureUnitRepo->create([
                'name' => $data['structure_unit']['name'],
                'organization_id' => $data['organization']['id'],
            ]);
            $data['structure_unit']['id'] = $structureUnit->getKey();
        }

        $data['structural_unit_id'] = $data['structure_unit']['id'];

        if (!$work = $this->query()->create($data)) {
            throw new RuntimeException('Error on creating work!',500);
        }
        return $work;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function update(int $id, array $data): ?Model
    {
        if (!$work = $this->find($id)) {
            throw new RuntimeException('Work not found!', 404);
        }
        if (!$work->update($data)) {
            throw new RuntimeException('Error on updating work!',500);
        }
        return $work;
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id): void
    {
        if (!$work = $this->find($id)) {
            throw new RuntimeException('Work not found!', 404);
        }
        if (!$work->delete()) {
            throw new RuntimeException('Error on destroying work!',500);
        }
    }

    public function getByUserID(int $id)
    {
        $perPage = 10;
        $query = $this->query();
        $query->where('user_id',$id);

        return $query->paginate($perPage);
    }
}
