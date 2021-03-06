<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
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

            return Response::create(['message' => 'Hasło jest nieprawidłowe'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return Response::create(['message' => 'Ten użytkownik nie istnieje'], Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return Response::create('');
    }
}
