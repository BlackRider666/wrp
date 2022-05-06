<?php

namespace App\Http\Controllers\API\Locale;

use App\Http\Controllers\Controller;
use App\Http\Requests\Locale\SearchLocaleRequest;
use App\Http\Requests\Locale\StoreLocaleRequest;
use App\Repo\LocaleKeyRepo;
use App\Repo\LocaleRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class LocaleController extends Controller
{
    /**
     * @var LocaleRepo
     */
    private $localeRepo;
    /**
     * @var LocaleKeyRepo
     */
    private $localeKeyRepo;

    public function __construct(
        LocaleRepo $localeRepo,
        LocaleKeyRepo $localeKeyRepo
    ){
        $this->localeRepo = $localeRepo;
        $this->localeKeyRepo = $localeKeyRepo;
    }

    /**
     * @param SearchLocaleRequest $request
     * @return JsonResponse
     */
    public function index(SearchLocaleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $locale = $this->localeRepo->getActiveByIsoCode($data['iso_code']);
        $keys = $locale->keys ?? new Collection();
        $resData = $keys->map(function ($item) {
            return [
                'key' => $item->key,
                'value' => $item->pivot->value,
            ];
        });
        return new JsonResponse($resData);
    }

    /**
     * @param StoreLocaleRequest $request
     * @return JsonResponse
     */
    public function store(StoreLocaleRequest $request): JsonResponse
    {
        $data = $request->validated();
        $language = $this->localeRepo->getActiveByIsoCode($data['iso_code']);
        $languageKey = $this->localeKeyRepo->create($language,$data);

        return new JsonResponse([
            'key' => $languageKey->key->key,
            'value' => $languageKey->value,
        ]);
    }

    /**
     * @return JsonResponse
     */
    public function getActive(): JsonResponse
    {
        return new JsonResponse($this->localeRepo->allActive());
    }
}
