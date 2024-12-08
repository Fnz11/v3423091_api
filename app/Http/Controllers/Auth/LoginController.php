<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Override the default authenticated method to check if the user is active.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return mixed
     */
    protected function authenticated($request, $user)
    {
        if (!$user->is_active) {
            Auth::logout();  // Logout if user is inactive
            return redirect()->route('login')->withErrors(['email' => 'Akun Anda tidak aktif.']);
        }

        return redirect()->intended($this->redirectPath());
    }
}
