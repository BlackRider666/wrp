<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\Student\AddStudentsRequest;
use App\Http\Requests\User\Student\AddTeachersRequest;
use App\Repo\UserRepo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * @var UserRepo
     */
    private $repo;

    public function __construct(UserRepo $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @param AddStudentsRequest $request
     * @return JsonResponse
     */
    public function addStudents(AddStudentsRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();

        $user->students()->sync($data['students']);

        return new JsonResponse([
            'user' => $user,
        ]);
    }

    /**
     * @param AddTeachersRequest $request
     * @return JsonResponse
     */
    public function addTeachers(AddTeachersRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();

        $user->teachers()->sync($data['students']);

        return new JsonResponse([
            'user' => $user,
        ]);
    }
}
