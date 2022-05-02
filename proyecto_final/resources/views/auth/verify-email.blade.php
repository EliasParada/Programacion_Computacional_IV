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
            </div>
            <div class="flex flex-wrap justify-center">
                <form class="max-w-sm bg-second-50 p-4 rounded-lg flex flex-wrap justify-center" method="POST" action="/email/verification-notification">
                    @csrf
                    <div class="flex flex-wrap -mx-3 mb-2 justify-center">
                        <div class="flex flex-wrap justify-center">
                        @if (session('resent'))
                            <div class="bg-first-500 text-white font-bold rounded-t px-4 py-2">
                                Se ha enviado un correo electrónico a tu cuenta.
                            </div>
                        @endif
                        </div>
                        <button class="bg-first-900 hover:bg-first-500 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                            Resend Email
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>