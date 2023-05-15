<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ChangePasswordRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterConfirmRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Requests\Auth\UpdatePhotoRequest;
use App\Http\Requests\Auth\UpdateUserRequest;
use App\Repo\UserRepo;
use BlackParadise\LaravelAdmin\Core\StorageManager;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @var UserRepo
     */
    private UserRepo $repository;

    /**
     * AuthController constructor.
     * @param UserRepo $repository
     */
    public function __construct(UserRepo $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $this->repository->findByEmail($data['email']);
        if (! $user || ! Hash::check($data['password'], $user->password) || !$user->verify) {
            return new JsonResponse([
                'message'   =>  'Wrong credentials',
            ],401);
        }

        return new JsonResponse([
            'token'     =>  $user->createToken(env('APP_NAME'))->plainTextToken,
        ]);
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['password'] = Hash::make('');
        $role = env('APP_DEFAULT_ROLE');
        $data['desc'] = '';//todo fix me

        try {
            $this->repository->create($data, $role);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'message'     =>  'Success',
        ]);
    }

    /**
     * @param RegisterConfirmRequest $request
     * @return JsonResponse
     */
    public function registerConfirm(RegisterConfirmRequest $request): JsonResponse
    {
        try {
            $user = $this->repository->confirmRegister($request->validated());
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'token'     =>  $user->createToken(env('APP_NAME'))->plainTextToken,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $this->repository->logout($request->user()->getKey());

        return new JsonResponse([
            'message'   =>  'Logout success',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        try {
            $user = $this->repository->findWith($request->user()->getKey(),['roles','city', 'country']);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'user' => $user,
        ]);
    }

    /**
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();

        try {
            $user = $this->repository->update($user->getKey(), $data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ], $e->getCode());
        }

        return new JsonResponse([
            'user'  => $user
        ]);
    }

    /**
     * @param UpdatePhotoRequest $request
     * @return JsonResponse
     */
    public function updatePhoto(UpdatePhotoRequest $request): JsonResponse
    {
        $user = $request->user();
        $storage = new StorageManager();
        if ($user->avatar !== null) {
            $storage->deleteFile($user->avatar,'user_avatar');
        }
        $data['avatar'] = $storage
            ->savePicture($request->file('photo'),'user_avatar',400);

        try {
            $user = $this->repository->update($user->getKey(), $data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ]);
        }

        return new JsonResponse([
            'user'  =>  $user,
        ]);
    }

    /**
     * @param ChangePasswordRequest $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $data['password'] = Hash::make($data['password']);

        try {
            $user = $this->repository->update($user->getKey(), $data);
        } catch (Exception $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
            ],500);
        }

        return new JsonResponse([
            'user'  => $user
        ]);
    }
}
