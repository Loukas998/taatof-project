<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    use ApiResponses;
    public function login(LoginRequest $request){
        $request->validated($request->all());

        if(!Auth::attempt($request->only('username', 'password')))
            return $this->error('Invalid credentials', 401);

        $user = User::firstWhere('username', $request->username);

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API_TOKEN for ' . $user->username,
                     ['*'])->plainTextToken
            ]
        );
    }

    public function logout(Request $request){
        Auth::logout();

        return $this->noContent();
    }
}
