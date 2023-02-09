<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAvatarRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

/**
 * @property UserRepository $repository
 */
class UserController extends Controller
{
    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function update(UserUpdateRequest $request): UserResource
    {
        return new UserResource($this->repository->findAndUpdate(Auth::user()->id, $request->all()));
    }

    public function avatar(UserAvatarRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'url' => $this->repository->setAvatar($request->file('avatar')),
        ]);
    }
}
