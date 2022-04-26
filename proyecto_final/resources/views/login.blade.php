<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Emotiva :v</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased bg-ui-300">
        @include('partials.nav')

        <div class="flex flex-wrap justify-center bg-ui-200 w-1/2 mx-auto my-4 p-4 ring-ui-100 rounded-lg">
            <form method="post" class="w-full max-w-sm">
                @csrf
                <div class="flex flex-col -mx-3 mb-6">
                    <button type="button" onclick="openNav('camera')">abrir</button>
                <camera-component v-bind:form="navs" ref="camera" v-if="navs['camera'].open" :two="false"></camera-component>
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">Email</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-first-name" autofocus type="email" value="{{ old('email') }}" placeholder="Jane@gmail.com" name="email" required>
                    @error('email')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Password</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="password" placeholder="******************" name="password" required>
                    @error('password')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <label for="remember" class="text-sm text-gray-700 dark:text-gray-500 font-bold">Recordarme</label>
                    </div>
                    @error('auth')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror
                </div>
                <div class="flex flex-col flex-wrap -mx-3 mb-2 text-center justify-center items-center space-y-2">
                    <div class="w-full px-3">
                        <button class="bg-ui-100 hover:bg-ui-300 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Iniciar sesion
                        </button>
                    </div>
                    <p class="text-center text-blue-500 text-xs">
                        <a href="{{ route('password.request') }}" class="text-blue-500 text-xs">¿Olvidaste tu contraseña?</a>
                    </p>
                    <p class="text-center text-blue-500 text-xs">
                        <a href="/login/google" class="flex items-center justify-center bg-ui-100 hover:bg-ui-300 text-white font-bold py-2 px-4 ml-1 rounded focus:outline-none focus:shadow-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-6" viewBox="0 0 16 16">
                            <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                        </svg>
                        Inicio facial
                        </a>
                    </p>
                    <p class="text-center text-blue-500 text-xs">
                        <a href="/login/google" class="flex items-center justify-center bg-ui-100 hover:bg-ui-300 text-white font-bold py-2 px-4 ml-1 rounded focus:outline-none focus:shadow-outline">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-6" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                        </svg>
                        Iniciar sesión con Google
                        </a>
                    </p>
                </div>
            </form>
        </div>
        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>