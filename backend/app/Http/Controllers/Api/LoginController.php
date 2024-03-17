<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /**
     * Login user. [POST /login]
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        // Create fake JWT.
        $token = 'eyJhbGciOiJIUzI1NiJ9.eyJJc3N1ZXIiOiJNYXRoZXdKYW1lcyIsImV4cCI6MTcxMTc5NzkxMSwiaWF0IjoxNzEwNjc0NzExfQ.HxDAOqRrM9R9lMYRnXoDMioC1iK1Jcd_NVcjPeEA3l0';

        // Return token.
        return response()->json([
            'token' => $token,
        ], 200);
    }
}
