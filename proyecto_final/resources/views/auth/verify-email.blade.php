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
            <h1 class="text-5xl">Email Verification</h1>
            @include('partials.nav')
        </div>

        <div class="flex flex-wrap justify-center">
             @if (session('resent'))
                <div class="w-full max-w-sm text-center text-green-500 p-4">
                    <p>A fresh verification link has been sent to your email address.</p>
                </div>
            @endif

            <div class="w-full max-w-sm text-center text-green-500 p-4">
                <p>A fresh verification link has been sent to your email address.</p>
            </div>
<!-- 
            <form class="w-full max-w-sm" method="POST" action="{{ route('verification.resend') }}">
                @csrf
                <div class="flex flex-col -mx-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-first-name">Email</label>
                    <input class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-first-name" autofocus type="email" value="{{ old('email') }}" placeholder="
                <?php
                    echo Auth::user()->email;
                ?>" name="email" required>
                </div>
                <div class="flex flex-col -mx-3 mb-6">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Send Email
                    </button>
                </div>
            </form> -->
            <form class="w-full max-w-sm" method="POST" action="/email/verification-notification">
                @csrf
                <div class="flex flex-col -mx-3 mb-6">
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                        Resend Email
                    </button>
                </div>
            </form>
        </div>
    </body>
</html>