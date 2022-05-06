<?php


namespace App\Repo;

use App\Models\Article\Article;
use App\Models\User\Work\Work;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use RuntimeException;

class ArticleRepo extends CoreRepo
{

    protected function getModelClass(): string
    {
        return Article::class;
    }

    public function create(array $data)
    {
        $data['year'] = Carbon::create($data['year']);
        if (!$article = $this->query()->create($data)) {
            throw new RuntimeException('Error on creating article!',500);
        }
        if (!$article->authors()->sync($data['authors'])) {
            throw new RuntimeException('Error on assign authors to article!',500);
        }
        return $article;
    }

    /**
     * @param array $data
     * @return LengthAwarePaginator
     */
    public function search(array $data): LengthAwarePaginator
    {
        $perPage = array_key_exists('perPage',$data)?$data['perPage']:10;
        $sortBy = $data['sortBy'] ?: 'year';
        $sortDesc = array_key_exists('sortDesc',$data)?$data['sortDesc']:true;
        $query = $this->query();

        if (array_key_exists('user_id',$data)) {
            $query->whereHas('authors', function (Builder $q) use ($data){
                $q->where('user_id',$data['user_id']);
                if (array_key_exists('nonApproved', $data)) {
                    $q->where('approved', false);
                } else {
                    $q->where('approved', true);
                }
            });
        }
        if (array_key_exists('title',$data)) {
            $query->where('title','like','%'.$data['title'].'%');
        }
        if (array_key_exists('country_id',$data)) {
            $query->where('country_id', $data['country_id']);
        }
        if (array_key_exists('city_id',$data)) {
            $query->where('city_id', $data['city_id']);
        }

        return $query->with(['category','authors'])->orderBy($sortBy,$sortDesc?'desc':'asc')->paginate($perPage);
    }

    public function update(int $id, array $data)
    {
        $data['year'] = Carbon::create($data['year']);
        if (!$article = $this->query()->find($id)) {
            throw new RuntimeException('Article not found!',404);
        }
        if (!$article->update($data)) {
            throw new RuntimeException('Error on updating article!',500);
        }
        if (!$article->authors()->sync($data['authors'])) {
            throw new RuntimeException('Error on assign authors to article!',500);
        }

        return $this->query()->with('category')->find($id);
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function delete(int $id): void
    {
        if (!$article = $this->query()->find($id)) {
            throw new RuntimeException('Article not found!',404);
        }
        if (!$article->authors()->sync([])) {
            throw new RuntimeException('Error on remove authors from article!',500);
        }
        if (!$article->delete()) {
            throw new RuntimeException('Error on destroying article!',500);
        }
    }

    /**
     * @param int $id
     * @return Builder|Builder[]|Collection|Model|Model[]|null
     */
    public function findWithCategory(int $id)
    {
        return $this->query()->with(['category','countryCreate','city'])->find($id);
    }

    /**
     * @param int $id
     * @param int $user_id
     */
    public function approveAuthor(int $id, int $user_id): void
    {
        if (!$article = $this->query()->find($id)) {
            throw new RuntimeException('Article not found!',404);
        }
        if (!$article->authors()->where('user_id', $user_id)->update(['approved' => true])) {
            throw new RuntimeException('Error on approve author on article!',500);
        }
    }
}
