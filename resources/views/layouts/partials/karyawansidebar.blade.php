<aside class="w-64 bg-gray-900 text-gray-200 flex flex-col">

    <div class="p-6 text-2xl font-bold text-white border-b border-gray-700">
        Kasir Panel
    </div>

    <nav class="flex-1 p-4 space-y-1">
        <a href="{{ route('kasir.index') }}"
           class="block px-4 py-2 rounded-lg
                  {{ request()->routeIs('kasir.index') && request('tab', 'pos') === 'pos' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            POS (Transaksi)
        </a>

        <a href="{{ route('kasir.index', ['tab' => 'online']) }}"
           class="block px-4 py-2 rounded-lg
                  {{ request()->routeIs('kasir.index') && request('tab') === 'online' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            Pesanan Online
        </a>

        <a href="{{ route('kasir.index', ['tab' => 'me']) }}"
           class="block px-4 py-2 rounded-lg
                  {{ request()->routeIs('kasir.index') && request('tab') === 'me' ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            Transaksi Saya
        </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="mt-6 px-4">
        @csrf
        <button type="button"
            onclick="openLogoutModal(this)"
            class="w-full py-2 rounded-lg bg-red-600 hover:bg-red-700 transition duration-200 text-white font-semibold shadow-md">
            Logout
        </button>
    </form>

</aside>
