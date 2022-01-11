<?php


namespace App\Repo;

use App\Models\Conference\Conference;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Exception;
use Highlight\Mode;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class ConferenceRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Conference::class;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        $sortBy = $data['sortBy'] ?: 'title';
        $sortDesc = array_key_exists('sortDesc',$data)?$data['sortDesc']:true;
        $query = $this->query();

        if (array_key_exists('title',$data)) {
            $query->where('title','like','%'.$data['title'].'%');
        }
        if (array_key_exists('city_id',$data)) {
            $query->where('city_id', $data['city_id']);
        }

        return $query->with(['organizers'])->orderBy($sortBy,$sortDesc?'desc':'asc')->paginate($perPage);
    }
    /**
     * @param array $data
     * @return Builder|Model
     */
    public function create(array $data)
    {
        if (!$conference = $this->query()->create($data)) {
            throw new RuntimeException('Error on creating conference!',500);
        }
        if (!$conference->organizers()->sync($data['organizers'])) {
            throw new RuntimeException('Error on assign organizers to conference!',500);
        }
        return $conference;
    }

    /**
     * @param int $id
     * @param array $data
     * @return Builder|Builder[]|Collection|Model|Model[]|null
     */
    public function update(int $id, array $data)
    {
        if (!$conference = $this->query()->find($id)) {
            throw new RuntimeException('Conference not found!',404);
        }
        if (!$conference->update($data)) {
            throw new RuntimeException('Error on updating conference!',500);
        }

        return $this->query()->find($id);
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id): void
    {
        if (!$conference = $this->query()->find($id)) {
            throw new RuntimeException('Conference not found!',404);
        }
        if (!$conference->delete()) {
            throw new RuntimeException('Error on destroying conference!',500);
        }
    }

    /**
     * @param int $id
     * @param array $with
     * @return Model|null
     */
    public function findWith(int $id, array $with): ?Model
    {
        return $this->query()->with($with)->find($id);
    }

    /**
     * @param int $id
     * @param array $articleData
     * @return Model|null
     */
    public function addArticle(int $id, array $articleData) : ?Model
    {
        if (!$conference = $this->query()->find($id)) {
            throw new RuntimeException('Conference not found!',404);
        }
        $article = (new ArticleRepo())->create($articleData);
        if (!$conference->articles()->sync($article,false)) {
            throw new RuntimeException('Error on attach article to conference!',500);
        }
        $conference = $this->query()->with(['city','country','organizers','articles'])->find($id);

        return $conference;
    }
}
