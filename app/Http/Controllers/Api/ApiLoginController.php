<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Add this import

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = User::where('email', $request->email)->first(); // Find user by email
            if (!$user->is_active) {
                Auth::logout();
                return response()->json([
                    'message' => 'Akun Anda tidak aktif.',
                    'status' => 403,
                    'data' => null
                ], 403);
            }
            $token = $user->createToken('API Token')->plainTextToken;
            return response()->json([
                'message' => 'Login successful',
                'status' => 200,
                'data' => ['token' => $token]
            ], 200);
        }

        return response()->json([
            'message' => 'Unauthorized',
            'status' => 401,
            'data' => null
        ], 401);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 200,
            'data' => null
        ], 200);
    }
}
