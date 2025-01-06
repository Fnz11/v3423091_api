<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'These credentials do not match our records.',
                'status' => 422,
                'data' => null
            ], 422);
        }

        if ($user->banned_until && $user->banned_until > now()) {
            $banTimeRemaining = Carbon::now()->diffForHumans($user->banned_until, true);
            return response()->json([
                'message' => "Your account is temporarily locked. Please try again in {$banTimeRemaining}.",
                'status' => 403,
                'data' => null
            ], 403);
        }

        if (!$user->email_verified_at) {
            return response()->json([
                'message' => 'Email not verified',
                'status' => 403,
                'data' => ['verification_url' => route('verify.show', ['email' => $user->email])]
            ], 403);
        }

        if (password_verify($request->password, $user->password)) {
            $token = $user->createToken('API Token')->plainTextToken;

            $user->login_attempts = 0;
            $user->last_login_attempt = null;
            $user->banned_until = null;
            $user->save();

            return response()->json([
                'message' => 'Login successful',
                'status' => 200,
                'data' => ['token' => $token]
            ], 200);
        }

        $this->handleFailedLogin($user);

        $attemptsLeft = 5 - $user->login_attempts;
        $message = $attemptsLeft > 0
            ? "Invalid credentials. {$attemptsLeft} attempts remaining."
            : "Too many failed attempts. Your account has been locked for 24 hours.";

        return response()->json([
            'message' => $message,
            'status' => 422,
            'data' => null
        ], 422);
    }

    protected function handleFailedLogin($user)
    {
        $now = Carbon::now();

        if (
            $user->last_login_attempt &&
            Carbon::parse($user->last_login_attempt)->diffInHours($now) >= 1
        ) {
            $user->login_attempts = 0;
        }

        $user->login_attempts++;
        $user->last_login_attempt = $now;

        if ($user->login_attempts >= 5) {
            $user->banned_until = $now->addHours(24);
        }

        $user->save();
    }

    public function logout(Request $request)
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'message' => 'Not authenticated',
                    'status' => 401,
                    'debug' => [
                        'token' => $request->bearerToken(),
                        'headers' => $request->headers->all()
                    ]
                ], 401);
            }

            /** @var \App\Models\User $user */
            $user = auth()->user();
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged out',
                'status' => 200
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Logout failed',
                'status' => 500,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
