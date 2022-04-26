<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request['termsandconditions'] = $request->filled('termsandconditions');
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);
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
        Auth::login($user);
        if ($user) {
            event(new Registered($user));
            return redirect('/')->with('success', 'Revisa tu email para activar tu cuenta');
        }
        return redirect('/login')->with('error', 'You are not registered!');
    }

    
}
