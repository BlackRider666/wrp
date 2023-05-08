<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SocialLink\StoreSocialLinkRequest;
use App\Http\Requests\User\SocialLink\UpdateSocialLinkRequest;
use App\Repo\SocialLinkRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    private SocialLinkRepo $repo;

    public function __construct(SocialLinkRepo $repo)
    {
        $this->repo = $repo;
    }

    public function index(Request $request): JsonResponse
    {
        $data['user_id'] = $request->user()->getKey();

        $links = $this->repo->search($data);

        return new JsonResponse ([
            'data' => $links,
        ]);
    }

    /**
     * @param StoreSocialLinkRequest $request
     * @return JsonResponse
     */
    public function store(StoreSocialLinkRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->getKey();

        try {
            $link = $this->repo->store($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 500);
        }

        return new JsonResponse([
            'link'  =>  $link,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateSocialLinkRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateSocialLinkRequest $request): JsonResponse
    {
        try {
            $link = $this->repo->update($id,$request->validated());
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], 500);
        }

        return new JsonResponse([
            'link'  =>  $link,
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->repo->delete($id);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'message' => 'Success',
        ]);
    }
}
