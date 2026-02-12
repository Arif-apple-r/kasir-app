<aside class="w-64 bg-gray-900 text-gray-200 flex flex-col">

    <!-- Logo -->
    <div class="p-6 text-2xl font-bold text-white border-b border-gray-700">
        Admin Panel
    </div>

    <!-- Menu -->
    <nav class="flex-1 p-4 space-y-1">

        <a href="{{ route('admin.dashboard') }}"
        class="block px-4 py-2 rounded-lg
                {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            Dashboard
        </a>

        <a href="{{ route('produk.index') }}"
        class="block px-4 py-2 rounded-lg
                {{ request()->routeIs('produk.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            Produk
        </a>

        <a href="{{ route('penjualan.index') }}"
        class="block px-4 py-2 rounded-lg
                {{ request()->routeIs('penjualan.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            Penjualan
        </a>

        <a href="{{ route('user.index') }}"
        class="block px-4 py-2 rounded-lg
                {{ request()->routeIs('user.*') ? 'bg-gray-700 text-white' : 'hover:bg-gray-700' }}">
            User
        </a>
    </nav>

    {{-- LOGOUT BUTTON --}}
    <form method="POST" action="{{ route('logout') }}" class="mt-6 px-4 logout-form">
        @csrf
        <button type="button"
            onclick="openLogoutModal(this)"
            class="w-full py-2 rounded-lg bg-red-600 hover:bg-red-700 transition duration-200 text-white font-semibold shadow-md">
            Logout
        </button>
    </form>

</aside>
