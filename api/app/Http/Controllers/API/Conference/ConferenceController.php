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
use App\Http\Resources\Conference\BaseConferenceResource;
use App\Http\Resources\Conference\ConferenceResource;
use App\Models\Conference\Conference;
use App\Repo\ConferenceRepo;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

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
     * @return AnonymousResourceCollection
     * @throws AuthorizationException
     */
    public function index(Request $request)
    {
        $data = $request->all();
        $this->authorize('viewAny', Conference::class);
        $conferences = $this->repo->search($data);
        return BaseConferenceResource::collection($conferences);
    }

    /**
     * @param CreateConferenceRequest $request
     * @return BaseConferenceResource|JsonResponse
     * @throws AuthorizationException
     */
    public function store(CreateConferenceRequest $request): JsonResponse|BaseConferenceResource
    {
        $data = $request->validated();
        $data['user_id'] = $request->user()->getKey();
        $this->authorize('create', Conference::class);
        try {
            $conference = $this->repo->create($data,$request->file('file'));
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], !is_int($e->getCode()) || $e->getCode() === 0 ?500:$e->getCode());
        }

        return new BaseConferenceResource($conference);
    }

    /**
     * @param int $id
     * @return ConferenceResource|JsonResponse
     */
    public function show(int $id): JsonResponse|ConferenceResource
    {
        try {
            $conference = $this->repo->findWithAll($id);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new ConferenceResource($conference);
    }

    /**
     * @param int $id
     * @param UpdateConferenceRequest $request
     * @return BaseConferenceResource|JsonResponse
     * @throws AuthorizationException
     */
    public function update(int $id, UpdateConferenceRequest $request): JsonResponse|BaseConferenceResource
    {
        $data = $request->validated();
        $conference = $this->repo->find($id);
        $this->authorize('update', $conference);

        try {
            $conference = $this->repo->update($id,$data,$request->file('file'));
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], !is_int($e->getCode()) || $e->getCode() === 0 ?500:$e->getCode());
        }

        return new BaseConferenceResource($conference);
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws AuthorizationException
     */
    public function destroy(int $id): JsonResponse
    {
        $conference = $this->repo->find($id);
        $this->authorize('delete', $conference);


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
     * @param Conference $conference
     * @param AddArticleRequest $request
     * @return ConferenceResource|JsonResponse
     * @throws AuthorizationException
     */
    public function addArticle(Conference $conference, AddArticleRequest $request): JsonResponse|ConferenceResource
    {
        $data = $request->validated();

        $this->authorize('addArticle', $conference);

        try {
            $conference = $this->repo->addArticle($conference,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], !is_int($e->getCode()) || $e->getCode() === 0 ?500:$e->getCode());
        }

        return new ConferenceResource($conference);
    }

    /**
     * @param int $id
     * @param AddOrgCommitteeRequest $request
     * @return ConferenceResource|JsonResponse
     * @throws AuthorizationException
     */
    public function addOrgCommittee(int $id, AddOrgCommitteeRequest $request): JsonResponse|ConferenceResource
    {
        $data = $request->validated();

        $conference = $this->repo->find($id);
        $this->authorize('addOrgCommittee', $conference);

        try {
            $conference = $this->repo->addOrgCommittee($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new ConferenceResource($conference);
    }

    /**
     * @param int $id
     * @param RemoveOrgCommitteeRequest $request
     * @return ConferenceResource|JsonResponse
     * @throws AuthorizationException
     */
    public function removeOrgCommittee(int $id, RemoveOrgCommitteeRequest $request): JsonResponse|ConferenceResource
    {
        $data = $request->validated();

        $conference = $this->repo->find($id);
        $this->authorize('removeOrgCommittee', $conference);

        try {
            $conference = $this->repo->removeOrgCommittee($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new ConferenceResource($conference);
    }

    /**
     * @param int $id
     * @param AddEditorsRequest $request
     * @return ConferenceResource|JsonResponse
     * @throws AuthorizationException
     */
    public function addEditors(int $id, AddEditorsRequest $request): JsonResponse|ConferenceResource
    {
        $data = $request->validated();

        $conference = $this->repo->find($id);
        $this->authorize('addEditor', $conference);

        try {
            $conference = $this->repo->addEditors($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new ConferenceResource($conference);
    }

    /**
     * @param int $id
     * @param RemoveEditorsRequest $request
     * @return ConferenceResource|JsonResponse
     * @throws AuthorizationException
     */
    public function removeEditors(int $id, RemoveEditorsRequest $request): JsonResponse|ConferenceResource
    {
        $data = $request->validated();

        $conference = $this->repo->find($id);
        $this->authorize('removeEditor', $conference);

        try {
            $conference = $this->repo->removeEditors($id,$data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new ConferenceResource($conference);
    }
}
