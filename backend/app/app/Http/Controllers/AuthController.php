<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request) {
        if (empty($request->email) || empty($request->password) || !($token = Auth::attempt($request->only('email', 'password')))) {
            return response()->json([
                'message' => 'E-mail ou senha estão incorretos.'
            ], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function user()
    {
        return response()->json(Auth::user());
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
        }
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        if (Auth::check()) {
            return $this->respondWithToken(Auth::refresh());
        }
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() * 60,
            'user' => new UserResource(Auth::user()),
        ]);
    }
}
