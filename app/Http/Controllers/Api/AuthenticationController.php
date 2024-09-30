<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function logout(){
        request()->user()->tokens()->delete();

        return $this->noContent();
    }

    public function update_user(UpdateUserRequest $request){
        $user = User::find(request()->user()->id);
        if(!$user){
            return $this->error('User doesn\'t exist', 401);
        }

        if(User::firstWhere('username', $request->username)){
           return $this->error('There is a user with the same user name', 400); 
        }

        $user->tokens()->delete();        
        $newPassword = Hash::make($request->password);
        $user->password = $newPassword;
        $user->username = $request->username;
        $user->save();

        return $this->noContent();
    }
}
