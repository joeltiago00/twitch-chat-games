<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginWithTwitchRequest;
use App\Http\Resources\User\UserResource;
use Game\Auth\Twitch\LoginWithTwitch;
use Illuminate\Http\Request;

class LoginWithTwitchController extends Controller
{
    public function __invoke(LoginWithTwitchRequest $request, LoginWithTwitch $loginWithTwitch): UserResource
    {
        return UserResource::make(
            $loginWithTwitch->handle($request->get('code'))
        );
    }
}
