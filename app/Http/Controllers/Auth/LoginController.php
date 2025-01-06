<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except(['logout', 'refresh']);
        $this->middleware('jwt.auth')->only(['logout', 'refresh']);
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !$this->checkPassword($user, $request->password)) {
            return $this->sendFailedResponse('Invalid credentials');
        }

        if ($this->isUserBanned($user)) {
            return $this->sendBannedResponse($user);
        } 

        if (!$user->email_verified_at) {
            return $this->sendVerificationNeededResponse($user);
        }

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        // Reset login attempts
        $this->resetLoginAttempts($user);

        return $this->sendLoginResponse($token, $user);
    }

    protected function checkPassword($user, $password)
    {
        // Check for old MD5 hash first (for existing users)
        if (strtoupper($user->password) === strtoupper(md5($password))) {
            // Update to bcrypt if old hash matches
            $user->update(['password' => bcrypt($password)]);
            return true;
        }
        
        // Check bcrypt hash
        return password_verify($password, $user->password);
    }

    protected function isUserBanned($user)
    {
        return $user->banned_until && $user->banned_until > now();
    }

    protected function sendBannedResponse($user)
    {
        $banTimeRemaining = Carbon::now()->diffForHumans($user->banned_until, true);
        return response()->json([
            'error' => "Your account is temporarily locked. Please try again in {$banTimeRemaining}."
        ], 423);
    }

    protected function sendVerificationNeededResponse($user)
    {
        return response()->json([
            'error' => 'Email verification required',
            'redirect' => route('verify.show', ['email' => $user->email])
        ], 403);
    }

    protected function resetLoginAttempts($user)
    {
        $user->update([
            'login_attempts' => 0,
            'last_login_attempt' => null,
            'banned_until' => null
        ]);
    }

    protected function sendLoginResponse($token, $user)
    {
        $response = response()->json([
            'success' => true,
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60,
            'user' => $user,
            'redirect' => $user->role === 'admin' ? '/admin/dashboard' : '/products'
        ]);

        // Set token in both cookie and response
        return $response->withCookie(
            cookie(
                'token',
                $token,
                JWTAuth::factory()->getTTL(), // minutes
                '/',
                null,
                false,    // secure - set to true in production with HTTPS
                true,     // httpOnly
                true,   // raw
                'lax'   // same-site policy
            )
        );
    }

    public function logout(Request $request)
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());

            // Clear the cookie
            return redirect()->route('login')->cookie('token', null, -1);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout, please try again'
            ], 500);
        }
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            return response()->json([
                'token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not refresh token'], 401);
        }
    }

    protected function sendFailedResponse($message)
    {
        if (request()->expectsJson()) {
            return response()->json([
                'error' => $message
            ], 422);
        }

        return back()->withErrors([
            'email' => $message
        ]);
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
}
