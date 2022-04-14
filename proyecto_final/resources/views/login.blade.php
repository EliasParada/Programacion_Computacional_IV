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
            <h1 class="text-5xl">Login</h1>
            @include('partials.nav')
        </div>

        <div class="flex flex-wrap justify-center">
            <form method="post" class="w-full max-w-sm">
                @csrf
                <div class="flex flex-col -mx-3 mb-6">
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
                        <input class="mr-2 leading-tight" type="checkbox" name="remember" id="remember">
                        <label class="text-sm text-gray-700 dark:text-gray-500" for="remember">Remember me</label>
                    </div>
                    @error('auth')
                        <p class="text-red-500 text-center">{{$message}}</p>
                    @enderror
                </div>
                <div class="flex flex-wrap -mx-3 mb-2">
                    <div class="w-full px-3">
                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Login
                        </button>
                    </div>
                    <p class="text-center text-blue-500 text-xs">
                        <a href="/reset">Forgot password?</a>
                    </p>
                    <p class="text-center text-blue-500 text-xs">
                        <a href="/login/google">Login with Google</a>
                </div>

            </form>
        </div>
    </body>
</html>