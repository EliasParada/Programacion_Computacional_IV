<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'FeelsGood') }}</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased dark bg-third-50">
        <div id="app">
            <div class="bg-first-900 dark:bg-first-900 w-full text-center justify-start text-white p-4 mb-4 flex flex-wrap space-x-6">
                <a href="/" class="text-center text-white hover:text-first-500">
                    {{ config('app.name', 'Feels Good') }}
                </a>
                <a href="/login" class="text-center text-white hover:text-first-500">Ingresar</a>
                <a href="/register" class="text-center text-white hover:text-first-500">Registrarse</a>
            </div>
            <div class="flex flex-wrap justify-center">
                @if (session('status'))
                    <div class="bg-first-500 text-white font-bold rounded-t px-4 py-2">
                        {{ session('status') }}
                    </div>
                @endif
                <form class="w-full max-w-sm bg-second-50 p-4 rounded-lg" method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">Correo</label>
                    <input class="appearance-none block w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:bg-white focus:border-gray-500" id="grid-first-name" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror
                    <div class="flex flex-wrap -mx-3 mb-2 justify-center">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Enviar correo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>