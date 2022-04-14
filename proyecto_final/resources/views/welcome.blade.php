<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Emotiva :v</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased dark">
        <!-- @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
            @endif -->
        
        <div class="bg-red-400 dark:bg-orange-400 w-full text-center text-white p-4 flex flex-wrap space-x-4">
            <h1 class="text-5xl">App Emotiva</h1>
            @include('partials.nav')
        </div>

        {{ Auth::user() }}

    </body>
</html>
