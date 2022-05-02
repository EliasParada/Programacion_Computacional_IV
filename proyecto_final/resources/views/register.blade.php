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
            <div class="bg-first-900 w-full text-center justify-start text-white p-4 mb-4 flex flex-wrap space-x-6">
                <a href="/" class="text-center text-white hover:text-first-500">
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="hover:stroke-slate-500 mr-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg> -->
                    {{ config('app.name', 'FeelsGood') }}
                </a>
                <a href="/login" class="text-center text-white hover:text-first-500">Ingresar</a>
                <a href="/register" class="text-center text-white hover:text-first-500">Registrarse</a>
            </div>
            <div class="flex flex-wrap justify-center pb-4">
                <form method="post" class="w-full max-w-sm bg-second-50 p-4 rounded-lg">
                    @csrf
                    <div class="flex flex-col -mx-3 mb-6">
                        <label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="grid-first-name">Capturar rostro</label>
                        <camera-component v-bind:form="navs" ref="camera" v-if="navs['camera'].open" :two="true"></camera-component>
                        <a href="#" class="bg-first-50 hover:bg-first-500 text-white rounded-lg px-4 py-2 flex flex-col items-center justify-center" onclick="openNav('camera')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="h-6 w-6 fill-current">
                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                            <span class="text-black" id="directoryFiles">Tomar una foto</span>
                            <input type="hidden" name="front" id="front" v-model="front" require value="{{ old('front') }}">
                            <input type="hidden" name="profile" id="profile" v-model="profile" require value="{{ old('profile') }}">
                        </a>
                        @error('front')
                            <p class="text-red-500 text-center">No se encontro ninguna imagen de portada</p>
                        @enderror
                        @error('profile')
                            <p class="text-red-500 text-center">No se encontro ninguna imagen de perfil</p>
                        @enderror
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-2" for="grid-last-name">Nombre</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Jane Doe" name="name" required value="{{ old('name') }}">
                        @error('name')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-2" for="grid-last-name">Correo</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-email" type="email" placeholder="jane_doe@gmail.com" name="email" required value="{{ old('email') }}">
                        @error('email')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-2" for="grid-last-name">Contraseña</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-pass" type="password" placeholder="******************" name="password" required>
                        @error('password')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2 mt-2" for="grid-last-name">Confirmar contraseña</label>
                        <input pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-confirm" type="password" placeholder="******************" name="password_confirmation" required>
                        @error('password_confirmation')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <div class="flex flex-row items-center mt-2">
                            <input pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" class="mr-1" type="checkbox" name="termsandconditions" id="termsandconditions" required>
                            <label class="text-sm text-gray-600" for="termsandconditions">Acepto los <a href="#" class="text-blue-500">terminos y condiciones de usos</a>.</label>
                        </div>
                        @error('termsandconditions')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <div class="flex flex-col mb-2 text-center justify-center items-center space-y-2">
                            <button class="bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Registrarse
                            </button>
                            <a class="inline-block align-baseline font-bold text-sm text-white" href="/login">
                                ¿Ya tienes una cuenta?
                            </a>
                            <span class="w-full m-2 flex text-center text-sm text-black font-bold items-center justify-between">
                                <span class="inline-block h-1 bg-gray-700 rounded-full pt-1 w-1/3"></span>
                                O
                                <span class="inline-block h-1 bg-gray-700 rounded-full pt-1 w-1/3"></span>
                            </span>
                            <p class="text-center text-blue-500 text-xs">
                                <a href="/login/google" class="flex items-center justify-center bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 ml-1 rounded focus:shadow-outline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="mr-6" viewBox="0 0 16 16">
                                    <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                </svg>
                                Iniciar sesión con Google
                                </a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>