<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>App Emotiva :v</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased">
        <div id="app" :class="{'dark': dark}">
            <div class="bg-blue-400 dark:bg-slate-800 w-full text-center text-black dark:text-white p-4 flex flex-wrap space-x-4">
                <h1 class="text-5xl">App Emotiva</h1>
                @include('partials.nav')
                <a href="#" class="text-white hover:text-orange-500" @click="dark = !dark">
                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            @if (Auth::check())
                <notes-component v-bind:form="navs" ref="notes" v-if="navs['notes'].open" :user="{{ Auth::user() }}"></notes-component>
                <profiles-component v-bind:form="navs" ref="profiles" v-if="navs['profiles'].open" :user="{{ Auth::user() }}"></profiles-component>
            @else
                <notes-component v-bind:form="navs" ref="notes" v-if="navs['notes'].open"></notes-component>
            @endif
        </div>

        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
