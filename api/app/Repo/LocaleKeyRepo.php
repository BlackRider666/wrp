<?php


namespace App\Repo;


use App\Models\Locale\Key\Key;
use App\Models\Locale\Locale;
use App\Models\Locale\LocaleKey\LocaleKey;
use BlackParadise\LaravelAdmin\Core\CoreRepo;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class LocaleKeyRepo extends CoreRepo
{
    protected function getModelClass(): string
    {
        return LocaleKey::class;
    }

    public function create(Locale $locale, array $keys)
    {
        $keysCol = collect($keys);

        $collectKeys = $keysCol->map(function ($item) {
            return Key::firstOrCreate([
                'key' => $item['key'],
                ],[
                'description' => 'From frontend',
            ]);
        });

        $localeKeys = $collectKeys->map(function ($key) use ($locale, $keysCol) {
            return LocaleKey::firstOrCreate([
                'key_id' => $key->getKey(),
                'locale_id' => $locale->getKey(),
            ], [
                'value'       => $keysCol->where('key',$key->key)->first()['value'],
            ]);
        });

        return $localeKeys;
    }
}
