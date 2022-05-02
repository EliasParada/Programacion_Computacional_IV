<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'FeelsGood') }}</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased bg-third-50">
        <div id="app">
            <div class="bg-first-900 dark:bg-first-900 w-full text-center justify-start text-white p-4 mb-4 flex flex-wrap space-x-6">
                <a href="/" class="text-center text-white hover:text-first-500">
                    {{ config('app.name', 'Feels Good') }}
                </a>
                <a href="/login" class="text-center text-white hover:text-first-500">Ingresar</a>
                <a href="/register" class="text-center text-white hover:text-first-500">Registrarse</a>
            </div>

            <div class="flex flex-wrap justify-center py-2">
                <form method="post" class="w-full max-w-sm bg-second-50 p-4 rounded-lg">

                    @csrf
                    <div class="flex flex-col -mx-3 mb-6">
                        <a href="#" class="bg-first-800 text-third-100 rounded-lg px-4 py-2 flex flex-col items-center justify-center" onclick="openNav('camera')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="h-6 w-6 fill-third-100">
                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                            <span class="text-third-100" id="directoryFiles">Tomar una foto</span>
                            <input type="hidden" name="facial" id="facial" v-model="facial" require value="{{ old('facial') }}">
                        </a>
                        <camera-component v-bind:form="navs" ref="camera" v-if="navs['camera'].open" :two="false"></camera-component>
                        <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="grid-first-name">Email</label>
                        <input class="appearance-none block w-full bg-gray-200 text-black border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:bg-white focus:border-gray-500" id="grid-first-name" autofocus type="email" value="{{ old('email') }}" placeholder="Jane@gmail.com" name="email" required>
                        @error('email')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <div class="flex items-center">
                            <input type="checkbox" name="remember" id="remember" class="mr-2 leading-tight focus:bg-white focus:border-gray-500">
                            <label for="remember" class="text-sm text-black dark:text-black font-bold">Recordarme</label>
                        </div>
                        @error('auth')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col flex-wrap -mx-3 mb-2 text-center justify-center items-center space-y-2">
                        <div class="w-full px-3">
                            <button class="bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 rounded focus:shadow-outline" type="submit">
                                Iniciar sesion
                            </button>
                        </div>
                        <span class="w-full m-2 flex text-center text-sm text-black font-bold items-center justify-between">
                            <span class="inline-block h-1 bg-gray-700 rounded-full pt-1 w-1/3"></span>
                            O
                            <span class="inline-block h-1 bg-gray-700 rounded-full pt-1 w-1/3"></span>
                        </span>
                        <p class="text-center text-blue-500 text-xs">
                            <a href="{{ route('password.request') }}" class="flex items-center justify-center bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 ml-1 rounded focus:shadow-outline">¿Olvidaste tu contraseña?</a>
                        </p>
                        <p class="text-center text-blue-500 text-xs">
                            <a href="/login/google" class="flex items-center justify-center bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 ml-1 rounded focus:shadow-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-6" viewBox="0 0 16 16">
                                    <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                                </svg>
                                Inicio tradicional
                            </a>
                        </p>
                        <p class="text-center text-blue-500 text-xs">
                            <a href="/login/google" class="flex items-center justify-center bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 ml-1 rounded focus:shadow-outline">
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