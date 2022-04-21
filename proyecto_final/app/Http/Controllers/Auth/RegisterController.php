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
        $request['termsandconditions'] = $request->filled('termsandconditions');
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);
        $user = User::create($credentials);
        if ($user) {
            event(new Registered($user));
            return redirect('/')->with('success', 'You are registered!');
        }
        return redirect('/login')->with('error', 'You are not registered!');
    }

    
}
