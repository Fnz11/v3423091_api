<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Rules\Captcha;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => ['required', new Captcha()],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first()
            ], 422);
        }

        try {
            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password), // Changed to bcrypt
                'otp' => $otp,
                'otp_expiry' => now()->addMinutes(10),
                'role' => User::ROLE_USER
            ]);

            try {
                Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
                    $message->to($request->email);
                    $message->subject('Email Verification OTP');
                });
            } catch (\Exception $e) {
                Log::error('Email sending failed: ' . $e->getMessage());
                // Continue execution even if email fails
            }

            return redirect()->route('verify.show', ['email' => $request->email]);
        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }
}
