<?php


namespace App\Repo;


use App\Models\User\User;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
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
     * @return LengthAwarePaginator|Builder[]|Collection|Model[]
     */
    public function search(array $data)
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

        if (array_key_exists('organization_id',$data)) {
            $query->whereHas('works', static function ($subQ) use ($data) {
                $subQ->whereHas('unit', static function ($q) use ($data) {
                    $q->where('organization_id', $data['organization_id']);
                });
                $subQ->where('finish',null);
            });
        }

        if (array_key_exists('forSelect', $data) && $data['forSelect']) {
            return $query->get(['id','first_name','second_name','surname']);
        }

        return $query->orderBy($sortBy,$sortDesc?'desc':'asc')->paginate($perPage);
    }

    /**
     * @param array $data
     * @return Builder[]|Collection|Model[]
     */
    public function searchAuthors(array $data)
    {
//        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        return $this->query()->get(['id','first_name','second_name','surname']);
    }

    /**
     * @param int $id
     * @param array $with
     * @return Builder|Model
     */
    public function findWith(int $id, array $with) {
        $query = $this->query();
        $query->where('id',$id);
        $query->with($with);
        return $query->firstOrFail();
    }

    /**
     * @param int $id
     * @return array
     */
    public function findPercentageOccupancy(int $id): array
    {
        $user = $this->query()->with(['works','grants','projects'])->find($id);
        $userFills = $user->getFillable();
        $accountFill = 0;
        foreach ($userFills as $fill) {
            if ($user->$fill !== null) {
                ++$accountFill;
            }
        }
        $account = ($accountFill / count($userFills));
        $works  = $user->works->count() > 0 ? 1:0;
        $grants = $user->grants->count() > 0 ? 1:0;
        $projects = $user->projects->count() > 0 ? 1:0;
        $total = (4*$account + 2*$works + 2*$grants + 2*$projects) / 10;

        return [
            'total'     =>  $total,
            'account'   =>  $account,
            'works'     =>  $works,
            'grants'    =>  $grants,
            'projects'  =>  $projects,
        ];
    }

    public function confirmRegister(array $data)
    {
        if (!$user = $this->findByEmail($data['email'])) {
            throw new RuntimeException('User not found!',404);
        }
        if (!$user->update([
            'password' => Hash::make($data['password']),
            'verify'   => true,
        ])) {
            throw new RuntimeException('Error on verify user', 500);
        }

        return $user;
    }
}
