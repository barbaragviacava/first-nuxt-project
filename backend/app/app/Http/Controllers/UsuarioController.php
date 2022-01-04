<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioAvatarRequest;
use App\Http\Requests\UsuarioUpdateRequest;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;

/**
 * @property UserRepository $repository
 */
class UsuarioController extends Controller
{
    /**
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  UsuarioUpdateRequest  $request
     */
    public function update(UsuarioUpdateRequest $request)
    {
        $this->repository->findAndUpdate(Auth::user()->id, $request->all());
    }

    /**
     * @param UsuarioAvatarRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function avatar(UsuarioAvatarRequest $request)
    {
        return response()->json([
            'url' => $this->repository->setAvatar($request->file('avatar')),
        ]);
    }
}
