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
    public function showRegistrationForm()
    {
        return view('register');
    }
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);
        Auth::login($user);
        // return redirect()->route('home')->with('success', 'You are logged in!');
        // event(new Registered($user = User::create($credentials)));
        // $this->guard()->login($user);
        // return $this->registered($request, $user)
        //     ?: redirect($this->redirectPath());
        if ($user) {
            event(new Registered($user));
            return redirect('/')->with('success', 'You are registered!');
        }
        return redirect('/login')->with('error', 'You are not registered!');
    }
}
