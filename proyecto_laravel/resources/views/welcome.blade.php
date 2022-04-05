<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="shortcut icon" href="data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCI+CiAgICA8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTSAxIDUgTCAxIDE5IFogWiBNIDEgNSBDIDEgMiAyIDEgNSAxIEwgMjAgMSBDIDIzIDEgMjQgMiAyNCA1IEwgMjQgMTkgQyAyNCAyMiAyMyAyMyAyMCAyMyBMIDUgMjMgQyAyIDIzIDEgMjIgMSAxOSIgZmlsbD0iI2YwZmRmNCIvPgogICAgPHBhdGggZmlsbC1ydWxlPSJldmVub2RkIiBjbGlwLXJ1bGU9ImV2ZW5vZGQiIGQ9Ik04LjUgN2MxLjA5MyAwIDIuMTE3LjI3IDMgLjc0M1YxN2E2LjM0NSA2LjM0NSAwIDAgMC0zLS43NDNjLTEuMDkzIDAtMi42MTcuMjctMy41Ljc0M1Y3Ljc0M0M1Ljg4MyA3LjI3IDcuNDA3IDcgOC41IDdaIiBmaWxsPSIjMGVhNWU5Ii8+CiAgICA8cGF0aCBmaWxsLXJ1bGU9ImV2ZW5vZGQiIGNsaXAtcnVsZT0iZXZlbm9kZCIgZD0iTTE1LjUgN2MxLjA5MyAwIDIuNjE3LjI3IDMuNS43NDNWMTdjLS44ODMtLjQ3My0yLjQwNy0uNzQzLTMuNS0uNzQzcy0yLjExNy4yNy0zIC43NDNWNy43NDNhNi4zNDQgNi4zNDQgMCAwIDEgMy0uNzQzWiIgZmlsbD0iIzdkZDNmYyIvPgogPC9zdmc+">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    </head>
    <body class="antialiased">
        <div id="app" class="font-sans bg-gray-300">
            <div >
                <nav class="bg-white shadow-md sticky top-0 w-full rounded-lg">
                    <div class="container mx-auto px-6 py-4">
                        <div class="flex items-center md:justify-between flex-col md:flex-row">
                            <div class="flex items-center ml-7 self-start md:ml-0">
                                <a href="index.html" class="text-gray-900 no-underline hover:no-underline font-bold text-2xl lg:text-4xl flex items-center">
                                    <svg class="h-14 w-14" viewBox="0 0 24 24" fill="none">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-sky-500 group-hover:fill-sky-500"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-sky-200 group-hover:fill-gray-900"></path>
                                    </svg>
                                    <span class="hidden md:block"><span class="text-sky-500">Sistema</span> Academico</span>
                                </a>
                            </div>
                            <div class="flex items-center">
                                <a @click="openForm('students')" href="#students" class="show block lg:inline-block lg:mt-0 text-gray-900 no-underline hover:text-sky-500 mr-4">Alumnos</a>
                                <a @click="openForm('subjects')" href="#subjects" class="show block lg:inline-block lg:mt-0 text-gray-900 no-underline hover:text-sky-500 mr-4">Materias</a>
                                <a @click="openForm('inscriptions')" href="#inscriptions" class="show block lg:inline-block lg:mt-0 text-gray-900 no-underline hover:text-sky-500 mr-4">Inscripciones</a>
                            </div>
                        </div>
                    </div>
                </nav>


                <div class="grid grid-cols-1">
                    <div class="fixed flex items-center justify-center w-full h-full rounded-lg shadow-lg -z-20">
                        <svg class="h-full w-full drop-shadow-2xl stroke-0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.5 7c1.093 0 2.117.27 3 .743V17a6.345 6.345 0 0 0-3-.743c-1.093 0-2.617.27-3.5.743V7.743C5.883 7.27 7.407 7 8.5 7Z" class="fill-gray-500 stroke-gray-600"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.5 7c1.093 0 2.617.27 3.5.743V17c-.883-.473-2.407-.743-3.5-.743s-2.117.27-3 .743V7.743a6.344 6.344 0 0 1 3-.743Z" class="fill-gray-300 stroke-gray-600"></path>
                        </svg>
                    </div>
                    <students-component v-bind:form="forms" ref="students" v-show="forms['students'].show" class="w-full"></students-component>
                    <subjects-component v-bind:form="forms" ref="subjects" v-show="forms['subjects'].show" class="w-full"></subjects-component>
                    <inscriptions-component v-bind:form="forms" ref="inscriptions" v-show="forms['inscriptions'].show" class="w-full"></inscriptions-component>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/app.js') }}"></script>
    </body>
</html>
