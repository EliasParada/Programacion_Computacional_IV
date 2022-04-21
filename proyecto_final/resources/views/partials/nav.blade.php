<a href="/">welcome</a>
@guest
    <a href="/login">login</a>
    <a href="/register">register</a>
@else
    <a href="#" onclick="openNav('profiles')" class="">Buscar</a>
    <a href="/dashboard">dashboard</a>
    <div class="dropdown">
        <div class="dropbtn">
            <img src="{{ Storage::url(Auth::user()->avatar) }}" alt="profile" class="profile w-14 h-14 mx-auto rounded-full">
            <p>{{ Auth::user()->name }}</p>
        </div>
        <div class="dropdown-content">
            <a href="/profile">Profile</a>
            <form action="/logout" method="POST">
                @csrf
                <a href="#" onclick="this.closest('form').submit()">logout</a>
            </form>
        </div>
    </div>
@endguest
<a href="#" onclick="openNav('notes')" class="">Notas</a>