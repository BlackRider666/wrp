<?php


namespace App\Repo;


use App\Models\Locale\Locale;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class LocaleRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return Locale::class;
    }

    /**
     * @param string $iso_code
     * @return Locale|Builder|Model|object
     */
    public function getActiveByIsoCode(string $iso_code)
    {
        $query = $this->query();
        $query->where('iso_code', $iso_code);
        $query->where('is_active',true);

        return $query->first();
    }


    /**
     * @return Builder[]|Collection|Model[]
     */
    public function allActive()
    {
        $query = $this->query();
        $query->where('is_active', true);

        return $query->get();
    }
}
