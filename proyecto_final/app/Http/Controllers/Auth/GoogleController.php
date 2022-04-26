<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\RegisterRequest;

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
        $user = User::where('email', $userLogin->getEmail())->first();
        if ($user) {
            Auth::login($user);
            return redirect('/dashboard');
        } else {
            return redirect('/google-register')->with('userLogin', $userLogin);
        }
    }
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);
        $user->email_verified_at = now();
        $user->save();
        Auth::login($user);
        return redirect('/')->with('<p class="text-green-500">You are logged in!</p>');
    }
}
