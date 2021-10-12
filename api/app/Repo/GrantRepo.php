<?php


namespace App\Repo;


use App\Models\User\Grant\Grant;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class GrantRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Grant::class;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        if (array_key_exists('user_id',$data)) {
            $this->query()->where('user_id',$data['user_id']);
        }

        return $this->query()->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data)
    {
        if (!$grant = $this->query()->create($data)) {
            throw new RuntimeException('Error on creating grant!',500);
        }

        return $grant;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Builder|Builder[]|Collection|Model|Model[]|null
     */
    public function update(int $id, array $data)
    {
        if (!$grant = $this->query()->find($id)) {
            throw new RuntimeException('Grant not found!',404);
        }
        if (!$grant->update($data)) {
            throw new RuntimeException('Error on updating grant!',500);
        }

        return $this->query()->find($id);
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id): void
    {
        if (!$grant = $this->query()->find($id)) {
            throw new RuntimeException('Grant not found!',404);
        }
        if (!$grant->delete()) {
            throw new RuntimeException('Error on destroying grant!',500);
        }
    }
}
