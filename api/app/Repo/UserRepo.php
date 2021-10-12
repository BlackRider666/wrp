<?php


namespace App\Repo;


use App\Models\User\User;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;
use Spatie\Permission\Models\Role;

class UserRepo extends CoreRepo
{

    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @param string $email
     * @return Builder|Model
     */
    public function findByEmail(string $email)
    {
        $query = $this->query();
        $query->where('email',$email);

        return $query->firstOrFail();
    }

    /**
     * @param array $data
     * @param string $roleName
     * @return User|null
     */
    public function create(array $data, string $roleName): ?User
    {
        if (!$role = Role::findByName($roleName)) {
            throw new RuntimeException('Role not found!',404);
        }
        if (!$user = User::create($data)) {
            throw new RuntimeException('Error on creating user!',500);
        }
        if (!$user->assignRole($role)) {
            throw new RuntimeException('Error on assign role to user!',500);
        }

        return $user;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Model|null
     */
    public function update(int $id, array $data): ?Model
    {
        if (!$user = $this->find($id)) {
            throw new RuntimeException('User not found!',404);
        }
        if(!$user->update($data)) {
            throw new RuntimeException('Error on updating user!',500);
        }

        return $user;
    }

    /**
     * @param int $id
     */
    public function logout(int $id): void
    {
        $user = $this->find($id);
        $user->tokens()->delete();
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        $sortBy = 'first_name';
        $sortDesc = array_key_exists('sortDesc',$data)?$data['sortDesc']:true;
        $query = $this->query();
        if (array_key_exists('title',$data)) {
            $query->where(function($q) use($data) {
                $q->where('first_name','like','%'.$data['title'].'%');
                $q->orWhere('second_name','like','%'.$data['title'].'%');
                $q->orWhere('surname','like','%'.$data['title'].'%');
            });
        }
        return $query->orderBy($sortBy,$sortDesc?'desc':'asc')->paginate($perPage);
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function searchAuthors(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        return $this->query()->paginate($perPage);
    }
}
