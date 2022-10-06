<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'FeelsGood') }}</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased dark">
        @include('partials.nav')

            <div class="flex flex-wrap justify-center">
                <form method="POST" class="w-full max-w-sm" action="/register/google">
                    @csrf
                    <div class="flex flex-col -mx-3 mb-6"><label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">Avatar</label>
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
                        <label pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Password</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="password" placeholder="******************" name="password" required>
                        @error('password')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <label pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Password Confirmation</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="password" placeholder="******************" name="password_confirmation" required>
                        @error('password_confirmation')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <div class="flex flex-col items-center">
                            <input class="mr-1" type="checkbox" name="termsandconditions" id="termsandconditions" required>
                            <label class="text-sm text-gray-600" for="termsandconditions">I agree to the <a href="#" class="text-blue-500">terms and conditions</a>.</label>
                        </div>
                        @error('termsandconditions')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        @if(session('userLogin'))
                            <input type="hidden" name="name" value="{{session('userLogin')->getName()}}">
                            <input type="hidden" name="email" value="{{session('userLogin')->getEmail()}}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Register
                            </button>
                        @else
                            <a href="/login/google" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Intentar de nuevo
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>