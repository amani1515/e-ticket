<h1>Cargo Man</h1>
<form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="text-red-700 hover:underline">Logout</button>
        </form>