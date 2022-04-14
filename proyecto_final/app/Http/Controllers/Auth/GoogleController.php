<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        $parameters = ['access_type' => 'offline',];
        return Socialite::driver('google')->scopes(['https://www.googleapis.com/auth/userinfo.email', 'https://www.googleapis.com/auth/userinfo.profile'])->redirect(env('GOOGLE_REDIRECT_URI'), $parameters);
    }
    public function handleGoogleCallback()
    {
        $userLogin = Socialite::driver('google')->user();
        $user = User::updateOrCreate(
            ['email' => $userLogin->getEmail()],
            ['refresh_token' => $userLogin->token,
            'name' => $userLogin->getName(),
            'password' => '$2y$10$psC69IU31VeMOKUOEKw89.FKEWU/gJVgUw3nYuYQdE91RiOCJczWG',
            // Verificar el email
            ]
        );
        Auth::login($user);
        return redirect('/');
    }
    public function logout(Request $request)
    {
        session('g_token', '');
        $this->guard()->logout();

        $request->session()->invalidate();
        return redirect('/');
    }
}
