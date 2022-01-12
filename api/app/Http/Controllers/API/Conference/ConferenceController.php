<?php

namespace App\Http\Controllers\API\Conference;

use App\Http\Controllers\Controller;
use App\Http\Requests\Conference\AddArticleRequest;
use App\Http\Requests\Conference\AddEditorsRequest;
use App\Http\Requests\Conference\AddOrgCommitteeRequest;
use App\Http\Requests\Conference\CreateConferenceRequest;
use App\Http\Requests\Conference\RemoveEditorsRequest;
use App\Http\Requests\Conference\RemoveOrgCommitteeRequest;
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
        $data['user_id'] = $request->user()->getKey();
        try {
            $conference = $this->repo->create($data,$request->file('file'));
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
            $conference = $this->repo->findWithAll($id);
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
            $conference = $this->repo->update($id,$data,$request->file('file'));
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

    /**
     * @param int $id
     * @param AddOrgCommitteeRequest $request
     * @return JsonResponse
     */
    public function addOrgCommittee(int $id, AddOrgCommitteeRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $conference = $this->repo->addOrgCommittee($id,$data);
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
     * @param RemoveOrgCommitteeRequest $request
     * @return JsonResponse
     */
    public function removeOrgCommittee(int $id, RemoveOrgCommitteeRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $conference = $this->repo->removeOrgCommittee($id,$data);
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
     * @param AddEditorsRequest $request
     * @return JsonResponse
     */
    public function addEditors(int $id, AddEditorsRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $conference = $this->repo->addEditors($id,$data);
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
     * @param RemoveEditorsRequest $request
     * @return JsonResponse
     */
    public function removeEditors(int $id, RemoveEditorsRequest $request): JsonResponse
    {
        $data = $request->validated();
        try {
            $conference = $this->repo->removeEditors($id,$data);
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
