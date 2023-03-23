<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * 使用者登入
     *
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request)
    {
        // 取得使用者帳密
        $credentials = $request->validated();

        // 驗證使用者帳密
        if (! Auth::attempt($credentials)) {
            return response([
                'message' => 'Provided email or password is incorrect.'
            ]);
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));
    }

    /**
     * 使用者登出
     *
     * @param Request $request
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response('', 204);
    }
}
