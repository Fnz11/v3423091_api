<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Tymon\JWTAuth\Facades\JWTAuth;

class VerificationController extends Controller
{
    public function show(Request $request)
    {
        return view('auth.verify', ['email' => $request->email]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('otp_expiry', '>', now())
            ->first();

        if (!$user) {
            return response()->json([
                'error' => 'Invalid or expired OTP'
            ], 422);
        }

        $user->email_verified_at = now();
        $user->otp = null;
        $user->otp_expiry = null;
        $user->save();

        // Generate JWT token
        $token = JWTAuth::fromUser($user);

        // Determine redirect based on user role
        $redirectPath = $user->role === 'admin' ? '/admin/dashboard' : '/products';

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully!',
            'token' => $token,
            'redirect' => $redirectPath
        ]);
    }

    public function resend(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found']);
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->otp = $otp;
        $user->otp_expiry = now()->addMinutes(10);
        $user->save();

        Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Email Verification OTP');
        });

        return back()->with('message', 'OTP has been resent');
    }
}
