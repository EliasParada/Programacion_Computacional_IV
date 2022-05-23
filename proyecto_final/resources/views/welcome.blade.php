<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'FeelsGood') }}</title>
        <link rel="stylesheet" href="{{asset('css/app.css')}}">

        <script src="storage/vendors/ckeditor/ckeditor.js"></script>
    </head>
    <body class="antialiased bg-third-50">
        @include('partials.nav')

            @if (Auth::check())
                <notes-component v-bind:form="navs" ref="notes" v-if="navs['notes'].open" :user="{{ Auth::user() }}"></notes-component>
                <profiles-component v-bind:form="navs" ref="profiles" v-if="navs['profiles'].open" :user="{{ Auth::user() }}"></profiles-component>
                <requests-component v-bind:form="navs" ref="requests" v-if="navs['requests'].open" :user="{{ Auth::user() }}"></requests-component>
            @else
                <notes-component v-bind:form="navs" ref="notes" v-if="navs['notes'].open"></notes-component>
            @endif
        </div>

        <!-- <textarea name="editor1" id="editor1" class="ckeditor" cols="30" rows="10"></textarea> -->

        <script src="{{asset('js/app.js')}}"></script>

        <!-- <script>
            CKEDITOR.replace( 'editor1' );
        </script> -->
    </body>
</html>
