<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Emotiva :v</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased dark">
        <div class="bg-cyan-700 dark:bg-blue-600 w-full text-center text-white p-4 flex flex-wrap space-x-4">
            <h1 class="text-5xl">Register</h1>
            @include('partials.nav')
        </div>

        <div class="flex flex-wrap justify-center">
            <form method="post" class="w-full max-w-sm" action="/register/google">
                @csrf
                <div class="flex flex-col -mx-3 mb-6"><label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">Avatar</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-first-name" autofocus type="file" required name="avatar" accept="image/*">
                    @error('avatar')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Password</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="password" placeholder="******************" name="password" required>
                    @error('password')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-last-name">Password Confirmation</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-last-name" type="password" placeholder="******************" name="password_confirmation" required>
                    @error('password_confirmation')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror
                    <div class="flex flex-col items-center">
                        <input class="mr-1" type="checkbox" name="terms&conditions" id="terms&conditions" required>
                        <label class="text-sm text-gray-600" for="terms&conditions">I agree to the <a href="#" class="text-blue-500">terms and conditions</a>.</label>
                    </div>
                    @error('terms&conditions')
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
                            Try Again
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </body>
</html>