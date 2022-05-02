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
                    {{ config('app.name', 'FeelsGood') }}
                </a>
                <a href="/login" class="text-center text-white hover:text-first-500">Ingresar</a>
                <a href="/register" class="text-center text-white hover:text-first-500">Registrarse</a>
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
                    </div>
                    <div class="flex flex-wrap -mx-3 mb-2">
                        <div class="w-full px-3">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                                Send Email
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>