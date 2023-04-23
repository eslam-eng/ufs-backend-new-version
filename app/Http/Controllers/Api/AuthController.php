<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\NotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreFcmTokenRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = $this->authService->loginWithEmailOrPhone(identifier: $request->identifier, password: $request->password);
            if (isset($request->fcm_token))
                $this->authService->setUserFcmToken($user,$request->fcm_token);
            return $user;
        } catch (Exception|NotFoundException $e) {
            return apiResponse($e->getMessage(), 'Unauthorized', $e->getCode());
        }
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return apiResponse(message: __('lang.logout_success'));
    }

    public function setFcmToken(StoreFcmTokenRequest $request): \Illuminate\Http\Response|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory
    {
        $user = auth()->user() ;
        if (!$user)
            return apiResponse(message: trans('lang.Unauthenticated'));
        $this->authService->setUserFcmToken($user , $request->fcm_token);
        return apiResponse(message: trans('lang.success_operation'));
    }
}
