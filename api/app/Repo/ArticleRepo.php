<?php


namespace App\Repo;

use App\Models\Article\Article;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
        if (!$article = Article::create($data)) {
            throw new RuntimeException('Error on creating article!',500);
        }
        if (!$article->authors()->sync($data['authors'])) {
            throw new RuntimeException('Error on assign role to user!',500);
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
        return $this->query()->with('category')->paginate($perPage);
    }
}
