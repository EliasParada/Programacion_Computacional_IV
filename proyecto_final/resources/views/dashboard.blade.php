<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Emotiva :v</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased dark">
        <div class="bg-yellow-700 dark:bg-amber-900 w-full text-center text-white p-4 flex flex-wrap space-x-4">
            <h1 class="text-5xl">Dashboard</h1>
            @include('partials.nav')
        </div>

    </body>
</html>