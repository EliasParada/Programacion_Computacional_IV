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
        $userLogin = Socialite::driver('google')->stateless()->user();
        $user = User::where('email', $userLogin->getEmail())->first();
        if ($user) {
            Auth::login($user);
            return redirect('/');
        } else {
            return redirect('/google-register')->with('userLogin', $userLogin);
        }
    }
    public function register(RegisterRequest $request)
    {
        $request['termsandconditions'] = $request->filled('termsandconditions');
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);
        $user->email_verified_at = now();
        $front = $credentials['front'];
        $front = explode(',', $front);
        $frontName = 'front.png';
        $path = 'storage/images/'.$credentials['email'].'/'.$frontName;
        if (!file_exists(public_path('storage/images/'.$credentials['email'].'/'.$user->id))) {
            mkdir(public_path('storage/images/'.$credentials['email'].'/'.$user->id), 0777, true);
        }
        file_put_contents($path, base64_decode($front[1]));
        $user->avatar = $path;
        $user->save();
        $profile = $credentials['profile'];
        $profile = explode(',', $profile);
        $profileName = 'profile.png';
        $path = 'storage/images/'.$credentials['email'].'/'.$profileName;
        file_put_contents($path, base64_decode($profile[1]));
        $user->save();
        Auth::login($user);
        return redirect('/')->with('success', '¡Bienvenido de nuevo!');
    }
}
