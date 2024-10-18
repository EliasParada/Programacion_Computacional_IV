<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permissions;
use Illuminate\Auth\Events\Registered;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $request['termsandconditions'] = $request->filled('termsandconditions');
        $credentials = $request->validated();
        $credentials['password'] = bcrypt($credentials['password']);

        $permissions = Permissions::get();
        if ($permissions->count() == 0) { 
            Permissions::create([
                'id' => 1,
                'name' => 'user',
                'description' => 'User',
            ]);
            Permissions::create([
                'id' => 2,
                'name' => 'admin',
                'description' => 'Administrator',
            ]);
        }

        $user = User::create($credentials);
        $front = $credentials['front'];
        $front = explode(',', $front);
        $frontName = 'front.png';
        $root = 'storage/images/';
        $path = $root.$credentials['email'].'/'.$frontName;
        if (!file_exists(public_path($root.$credentials['email'].'/'.$user->id))) {
            mkdir(public_path($root.$credentials['email'].'/'.$user->id), 0777, true);
        }
        file_put_contents($path, base64_decode($front[1]));
        $user->avatar = $path;
        $user->save();
        $profile = $credentials['profile'];
        $profile = explode(',', $profile);
        $profileName = 'profile.png';
        $path = $root.$credentials['email'].'/'.$profileName;
        file_put_contents($path, base64_decode($profile[1]));
        Auth::login($user);
        if ($user) {
            event(new Registered($user));
            return redirect('/')->with('success', 'Revisa tu email para activar tu cuenta');
        }
        return redirect('/login')->with('error', 'You are not registered!');
    }

    public function save(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'image' => 'required|string',
        ]);

        dd($request->input('image'));

        // Obtener el string base64 de la imagen
        $imageData = $request->input('image');

        // Decodificar el base64 para obtener el contenido binario de la imagen
        $front = $imageData;
        $front = explode(',', $front);
        $frontName = 'front.png';
        $root = 'storage/images/analicer/';
        $path = $root.$frontName;
        if (!file_exists(public_path($path))) {
            mkdir(public_path($path), 0777, true);
        }
        file_put_contents($path, base64_decode($front[1]));

    }


    
}
