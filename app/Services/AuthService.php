<?php

namespace App\Services;


use App\Models\User;
use App\Resources\UserResource;
use App\Traits\ApiResponses;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


class AuthService extends LaravelServiceClass
{
    use ApiResponses;


    public function login($request)
    {
        $validatedData = $request->validated();


        $credentials = ['password' => $validatedData['password'],'email'=>$validatedData['email']];


        if (! Auth::attempt($credentials)){
         return    $this->error('Invalid Credentials ',401);
        }


            $user = User::firstWhere('email',$credentials['email']);


        return $this->ok(
            'Authenticated' ,
            [
                'token'=> $user->createToken('API token for')->plainTextToken,
                'user'=>UserResource::make($user),
            ]

        );

    }

    public function logout($request = null)
    {
        $request->user()->currentAccessToken()->delete();
        Session::forget(['api_token','user']);
        return $this->ok('Logged out successfully');

    }







}
