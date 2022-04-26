<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Emotiva :v</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased dark">
        @include('partials.nav')
            <div class="flex flex-wrap justify-center">
                <form method="post" class="w-full max-w-sm bg-first-200 p-4">
                    @csrf
                    <div class="flex flex-col -mx-3 mb-6"><label class="block uppercase tracking-wide text-black text-xs font-bold mb-2" for="grid-first-name">Avatar</label>
                        <camera-component v-bind:form="navs" ref="camera" v-if="navs['camera'].open" :two="true"></camera-component>
                        <a href="#" class="bg-first-800 text-third-100 rounded-lg px-4 py-2 flex flex-col items-center justify-center" onclick="openNav('camera')">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" class="h-6 w-6 fill-third-100">
                                <path d="M1.5 1a.5.5 0 0 0-.5.5v3a.5.5 0 0 1-1 0v-3A1.5 1.5 0 0 1 1.5 0h3a.5.5 0 0 1 0 1h-3zM11 .5a.5.5 0 0 1 .5-.5h3A1.5 1.5 0 0 1 16 1.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 1-.5-.5zM.5 11a.5.5 0 0 1 .5.5v3a.5.5 0 0 0 .5.5h3a.5.5 0 0 1 0 1h-3A1.5 1.5 0 0 1 0 14.5v-3a.5.5 0 0 1 .5-.5zm15 0a.5.5 0 0 1 .5.5v3a1.5 1.5 0 0 1-1.5 1.5h-3a.5.5 0 0 1 0-1h3a.5.5 0 0 0 .5-.5v-3a.5.5 0 0 1 .5-.5z"/>
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                            </svg>
                            <span class="text-third-100" id="directoryFiles">Tomar una foto</span>
                            <input type="hidden" name="front" id="front" v-model="front" require value="{{ old('front') }}">
                            <input type="hidden" name="profile" id="profile" v-model="profile" require value="{{ old('profile') }}">
                        </a>
                        @error('avatar')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Name</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="text" placeholder="Jane Doe" name="name" required>
                        @error('name')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Email</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-email" type="email" placeholder="jane_doe@gmail.com" name="email" required>
                        @error('email')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Password</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-pass" type="password" placeholder="******************" name="password" required>
                        @error('password')
                            <p class="text-red-500 text-center">{{$message}}</p>
                        @enderror
                        <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Password Confirmation</label>
                        <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-confirm" type="password" placeholder="******************" name="password_confirmation" required>
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
                        <div class="flex items-center justify-between">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Register
                            </button>
                            <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="/login">
                                Already have an account?
                            </a>    
                            <p class="text-center text-blue-500 text-xs">
                                <a href="/login/google">Login with Google</a>
                            </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>