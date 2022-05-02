<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    public function login(LoginRequest $request)
    {
        $remember = $request->filled('remember');
        if (Auth::attempt($request->validated(), $remember)) {
            session()->regenerate();
            return redirect()->intended('/')->with('success', '¡Bienvenido de nuevo!');
        }
        throw ValidationException::withMessages([
            'auth' => __('auth.failed'),
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You are logged out!');
    }

}
