<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('name', $request->get('user'))->first();

        if ($user)
        {
            if (Hash::check($request->get('password'), $user->password))
            {
                $token = $user->createToken('Api token')->accessToken;

                return Response::create(['token' => $token], Response::HTTP_OK);
            }

            return Response::create(['message' => 'Password is wrong'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return Response::create(['message' => 'User not exists'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return Response::create('');
    }
}
