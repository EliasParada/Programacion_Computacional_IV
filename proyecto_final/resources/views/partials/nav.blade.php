<div id="app">
    <div class="bg-first-500 dark:bg-first-900 w-full text-center text-white p-4 flex flex-wrap space-x-6">
        <a href="/" class="flex-1 text-center text-white hover:text-blue-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" class="hover:stroke-slate-500 mr-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </a>
        <a href="#" onclick="openNav('notes')" class="flex-1 text-center text-white hover:text-blue-200">Notas</a>
        @guest
            <a href="/login" class="flex-1 text-center text-white hover:text-blue-200">Ingresar</a>
            <a href="/register" class="flex-1 text-center text-white hover:text-blue-200">Registrarse</a>
        @else
            <a href="#" onclick="openNav('profiles')" class="">Buscar</a>
            <div class="dropdown">
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
            </div>
        @endguest
    </div>

    <div class="bg-first-50 bg-first-100 bg-first-200 bg-first-300 bg-first-400 bg-first-500 bg-first-600 bg-first-700 bg-first-800 bg-first-900 text-first-50 text-first-100 text-first-200 text-first-300 text-first-400 text-first-500 text-first-600 text-first-700 text-first-800 text-first-900">
        <div class="bg-second-50 bg-second-100 bg-second-200 bg-second-300 bg-second-400 bg-second-500 bg-second-600 bg-second-700 bg-second-800 bg-second-900 text-second-50 text-second-100 text-second-200 text-second-300 text-second-400 text-second-500 text-second-600 text-second-700 text-second-800 text-second-900">
            <div class="bg-third-50 bg-third-100 bg-third-200 bg-third-300 bg-third-400 bg-third-500 bg-third-600 bg-third-700 bg-third-800 bg-third-900 text-third-50 text-third-100 text-third-200 text-third-300 text-third-400 text-third-500 text-third-600 text-third-700 text-third-800 text-third-900">
            </div>
        </div>
    </div>