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

    public function create(Locale $locale, array $data)
    {
        if (!$key = Key::firstOrCreate([
            'key' => $data['key'],
            'description' => 'From frontend '.$data['key'],
        ])) {
            throw new RuntimeException('Error on creating key!',500);
        }
        if (!$localeKey = LocaleKey::firstOrCreate([
            'key_id' => $key->getKey(),
            'locale_id' => $locale->getKey(),
        ], [
            'value'       => $data['value'],
        ])) {
            throw new RuntimeException('Error on creating localeKey!',500);
        }

        return $localeKey;
    }
}
