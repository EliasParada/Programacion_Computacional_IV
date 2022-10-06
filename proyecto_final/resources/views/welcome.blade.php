<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'FeelsGood') }}</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
    </head>
    <body class="antialiased bg-third-50">
        @include('partials.nav')

            @if (Auth::check())
                <span id="user" class="hidden">
                    <ul>
                        <li>{{ Auth::user()->id }}</li>
                        <li>{{ Auth::user()->name }}</li>
                        <li>{{ Auth::user()->email }}</li>
                    </ul>
                </span>
                <notes-component v-bind:form="navs" ref="notes" v-if="navs['notes'].open" :user="{{ Auth::user() }}"></notes-component>
                <chat-component v-bind:form="navs" ref="chat" v-if="navs['chat'].open" :user="{{ Auth::user() }}" :friend="friend"></chat-component>
                <profiles-component v-bind:form="navs" ref="profiles" v-if="navs['profiles'].open" :user="{{ Auth::user() }}"></profiles-component>
                <requests-component v-bind:form="navs" ref="requests" v-if="navs['requests'].open" :user="{{ Auth::user() }}"></requests-component>

                <news-component v-bind:form="navs" ref="news" v-if="navs['news'].open" :user="{{ Auth::user() }}"></news-component>
                <setting-component v-bind:form="navs" ref="settings" v-if="navs['settings'].open" :user="{{ Auth::user() }}"></setting-component>
                <expert-component v-bind:form="navs" ref="expert" v-if="navs['expert'].open" :user="{{ Auth::user() }}"></expert-component>
                <div>
                </div>
            @else
                <notes-component v-bind:form="navs" ref="notes" v-if="navs['notes'].open"></notes-component>
            @endif
        </div>
        <script src="https://cdn.socket.io/4.5.0/socket.io.min.js" integrity="sha384-7EyYLQZgWBi67fBtVxw60/OWl1kjsfrPFcaU0pp0nAh+i8FD068QogUvg85Ewy1k" crossorigin="anonymous"></script>
        <script src="{{asset('js/app.js')}}"></script>
    </body>
</html>
