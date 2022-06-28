<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(AuthRequest $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('ApiPresenceApp')->plainTextToken;
            $success['data']['name'] =  $user->name;
            $success['data']['username'] =  $user->username;
            $success['data']['email'] =  $user->email;

            return response()->json([
                'success' => true,
                'data' => $success,
                'message' => 'Berhasil Login'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Username atau password salah'
            ], 422);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Logout'
        ]);
    }
}
