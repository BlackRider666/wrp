<?php

namespace App\Http\Controllers\API\Conference;

use App\Http\Controllers\Controller;
use App\Http\Requests\Conference\AddArticleRequest;
use App\Http\Requests\Conference\CreateConferenceRequest;
use App\Http\Requests\Conference\UpdateConferenceRequest;
use App\Repo\ConferenceRepo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    /**
     * @var ConferenceRepo
     */
    private $repo;

    public function __construct(ConferenceRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $request->all();

        return new JsonResponse($this->repo->search($data));
    }

    /**
     * @param CreateConferenceRequest $request
     * @return JsonResponse
     */
    public function store(CreateConferenceRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $conference = $this->repo->create($data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'conference'  =>  $conference,
        ]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $conference = $this->repo->findWith($id,['city','country','organizers','articles']);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'conference'  =>  $conference,
        ]);
    }

    /**
     * @param int $id
     * @param UpdateConferenceRequest $request
     * @return JsonResponse
     */
    public function update(int $id, UpdateConferenceRequest $request): JsonResponse
    {
        $data = $request->validated();

        try {
            $conference = $this->repo->update($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'conference'  =>  $conference,
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
            ],500);
        }

        return new JsonResponse([
            'message'  =>  'Conference deleted!',
        ]);
    }

    /**
     * @param int $id
     * @param AddArticleRequest $request
     * @return JsonResponse
     */
    public function addArticle(int $id, AddArticleRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $conference = $this->repo->addArticle($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'conference'  =>  $conference,
        ]);
    }
}
