<?php


namespace App\Service;


use App\Models\Locale\Key\Key;
use App\Models\Locale\Locale;
use App\Models\Locale\LocaleKey\LocaleKey;
use JoggApp\GoogleTranslate\GoogleTranslate;
use JoggApp\GoogleTranslate\GoogleTranslateClient;
use RuntimeException;

class TranslateLocaleService
{
    /**
     * @param int $id Locale id
     * @return string
     */
    public function translate(int $id):string
    {
        $locale = Locale::with('keys')->where('id',$id)->first();
        $client = (new GoogleTranslateClient(config('googletranslate')));
        $translateClient = (new GoogleTranslate($client));
        $languages = $translateClient->languages();
        if(!in_array($locale->iso_code, $languages, true)) {
            throw new RuntimeException('Incorrect iso code',500);
        }
        $keys = Key::with('locales')->get();
        $to_translate = [];
        $key_ids = [];
        $translated_with_key_id = [];
        $i = 0;
        foreach ($keys as $key) {
            $to_translate[$i] = $key->locales->first()->pivot->value;
            $key_ids[$i] = $key->getKey();
            $i++;
        }
        $translated = $translateClient->translate($to_translate,$locale->iso_code);
        foreach($translated as $k => $value) {
            $translated_with_key_id[] = [
                'key_id' => $key_ids[$k],
                'value'  => $value['translated_text'],
            ];
        }
        foreach($translated_with_key_id as $lk) {
            LocaleKey::updateOrCreate([
                'key_id' => $lk['key_id'],
                'locale_id' => $locale->getKey(),
            ], [
                'value'       => $lk['value'],
            ]);
        }
        return 'Success';
    }
}
