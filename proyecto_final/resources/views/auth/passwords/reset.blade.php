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
                <form class="w-full max-w-sm bg-second-50 p-4 rounded-lg" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <input id="email" type="email" class="hidden" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                    <p class="text-center text-black text-sm">{{ $email ?? old('email') }}</p>

                    <label for="password" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Nueva contraseña</label>
                    <input id="password" type="password" class="appearance-none block w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:bg-white focus:border-gray-500" name="password" required autocomplete="new-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror

                    <label for="password-confirm" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2">Confirmar contraseña</label>
                    <input id="password-confirm" type="password" class="appearance-none block w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:bg-white focus:border-gray-500" name="password_confirmation" required autocomplete="new-password">

                    <div class="flex flex-wrap -mx-3 mb-2">
                        <div class="w-full px-3">
                            <button type="submit" class="bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Guardar contraseña
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>