<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApiVerificationController extends Controller
{
    public function verify(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'otp' => 'required|string|size:6',
            ]);

            $user = User::where('email', $validated['email'])
                ->where('otp', $validated['otp'])
                ->where('otp_expiry', '>', now())
                ->first();

            if (!$user) {
                return response()->json([
                    'message' => 'Invalid or expired OTP',
                    'status' => 422,
                    'data' => null
                ], 422);
            }

            $user->email_verified_at = now();
            $user->otp = null;
            $user->otp_expiry = null;
            $user->save();

            // Create new token
            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'Email verified successfully',
                'status' => 200,
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error verifying email',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }

    public function resend(Request $request)
    {
        try {
            $validated = $request->validate([
                'email' => 'required|email'
            ]);

            $user = User::where('email', $validated['email'])->first();

            if (!$user) {
                return response()->json([
                    'message' => 'User not found',
                    'status' => 404,
                    'data' => null
                ], 404);
            }

            $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->otp = $otp;
            $user->otp_expiry = now()->addMinutes(10);
            $user->save();

            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
                $message->to($user->email);
                $message->subject('Email Verification OTP');
            });

            return response()->json([
                'message' => 'OTP sent successfully',
                'status' => 200,
                'data' => ['email' => $user->email]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error sending OTP',
                'status' => 500,
                'data' => null
            ], 500);
        }
    }
}
