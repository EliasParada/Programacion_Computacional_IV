<div id="app">
    <div class="bg-first-900 dark:bg-first-900 w-full text-center justify-start text-white p-4 mb-4 flex flex-wrap space-x-6">
        <a href="/" class="text-center text-white hover:text-first-500">
            {{ config('app.name', 'FeelsGood') }}
        </a>
        <a href="#" onclick="openNav('notes')" class="text-center text-white hover:text-first-500">Notas</a>
        @guest
            <a href="/login" class="text-center text-white hover:text-first-500">Ingresar</a>
            <a href="/register" class="text-center text-white hover:text-first-500">Registrarse</a>
        @else
            <a href="#" onclick="openNav('news')" class="text-center text-white hover:text-first-500">Noticias</a>
            <a href="#" onclick="openNav('profiles')" class="text-center text-white hover:text-first-500">Buscar</a>
            <a href="#" onclick="openNav('requests')" class="text-center text-white hover:text-first-500">Solicitudes</a>
            <!-- Si is_request mostrar un circulo usando animaciones de tailwind -->
            <!-- <a v-if="is_request" href="#" onclick="openNav('requests')" class="text-center text-white hover:text-first-500">
                <svg class="h-6 w-6 fill-current text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 20a10 10 0 1 1 0-20 10 10 0 0 1 0 20zm-5.6-4.29a9.95 9.95 0 0 1 11.2 0 8 8 0 1 0-11.2 0zm6.12-7.64l3.02-3.02 1.41 1.41-3.02 3.02a2 2 0 1 1-1.41-1.41z"/>
                </svg>
            </a> -->
            <!-- <div class="dropdown">
                <div class="dropbtn">
                    <img src="{{ Auth::user()->avatar }}" alt="profile" class="profile w-14 h-14 mx-auto rounded-full">
                    <p>{{ Auth::user()->name }}</p>
                </div>
                <div class="dropdown-content">
                    <form action="/logout" method="POST">
                        @csrf
                        <a href="#" onclick="this.closest('form').submit()">Cerrar Sesion</a>
                    </form>
                </div>
            </div> -->
            <!-- Usar estilos de tailwindcss -->
            <div class="flex flex-col items-center absolute top-0 right-0 h-16 w-46 overflow-hidden hover:h-fit">
                <img src="{{ Auth::user()->avatar }}" alt="profile" class="profile w-auto h-16 rounded-full justify-end">
                <div class="flex flex-col justify-center items-center bg-first-900 border-1 border-first-500 rounded-lg h-full w-full p-2 z-10">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                    <div class="dropbtn">
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                    <div class="dropbtn">
                        <a href="#" onclick="openNav('settings')" class="text-center text-white hover:text-first-500">Ajustes</a>
                    </div>
                    <div class="dropdown-content">
                        <form action="/logout" method="POST">
                            @csrf
                            <a href="#" class="text-center text-white hover:text-first-500" onclick="this.closest('form').submit()">Cerrar Sesion</a>
                        </form>
                    </div>
                </div>
            </div>
        @endguest
    </div>

    <div class="bg-first-50 bg-first-100 bg-first-200 bg-first-300 bg-first-400 bg-first-500 bg-first-600 bg-first-700 bg-first-800 bg-first-900 text-first-50 text-first-100 text-first-200 text-first-300 text-first-400 text-first-500 text-first-600 text-first-700 text-first-800 text-first-900">
        <div class="bg-second-50 bg-second-100 bg-second-200 bg-second-300 bg-second-400 bg-second-500 bg-second-600 bg-second-700 bg-second-800 bg-second-900 text-second-50 text-second-100 text-second-200 text-second-300 text-second-400 text-second-500 text-second-600 text-second-700 text-second-800 text-second-900">
            <div class="bg-third-50 bg-third-100 bg-third-200 bg-third-300 bg-third-400 bg-third-500 bg-third-600 bg-third-700 bg-third-800 bg-third-900 text-third-50 text-third-100 text-third-200 text-third-300 text-third-400 text-third-500 text-third-600 text-third-700 text-third-800 text-third-900">
            </div>
        </div>
    </div>