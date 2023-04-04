<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\LoginFBRequest;

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
     * 使用FB登入
     *
     * @return json
     */
    public function login_fb()
    {
        /** @var User $user */
        $user = (new \App\Models\User)::where('email', request('email'))->first();

        if ($user == null) {
            (new \App\Models\User)::insert(['email' => request('email'), 'name' => request('name')]);
            $user = (new \App\Models\User)::where('email', request('email'))->first();
        }

        $token = $user->createToken('main')->plainTextToken;

        return response(compact('user', 'token'));
    }

    /**
     * 使用者登出
     *
     * @param Request $request
     *
     * @return json
     */
    public function logout(Request $request)
    {
        /** @var User $user */
        $user = $request->user();
        $user->currentAccessToken()->delete();

        return response('', 204);
    }
}
