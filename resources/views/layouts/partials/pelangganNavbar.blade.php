<nav class="bg-white shadow-md sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Logo & Brand --}}
            <div class="flex items-center">
                <a href="{{ route('pelanggan.home') }}" class="text-2xl font-bold text-blue-600">
                    Toko Cihuy!
                </a>
            </div>

            {{-- Menu Tengah (Opsional) --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ route('pelanggan.home') }}" class="text-gray-700 hover:text-blue-600 font-medium">Home</a>
                <a href="{{ route('pelanggan.produk.index') }}" class="text-gray-700 hover:text-blue-600 font-medium">Katalog</a>
                <a href="{{ route('pelanggan.riwayat') }}" class="text-gray-700 hover:text-blue-600 font-medium">Pesanan Saya</a>
            </div>

            {{-- Menu Kanan (Cart & User) --}}
            <div class="flex items-center space-x-5">
                {{-- Keranjang dengan Badge --}}
                <a href="{{ route('pelanggan.cart.index') }}" class="relative text-gray-700 hover:text-blue-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    {{-- Badge Jumlah Item (Logikanya ambil dari Session Cart) --}}
                    <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                        {{ session('cart') ? count(session('cart')) : 0 }}
                    </span>
                </a>

                @auth
                    <div class="flex items-center space-x-4 border-l pl-4">
                        <span class="text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}" class="logout-form">
                            @csrf
                            <button type="button"
                                onclick="openLogoutModal(this)"
                                class="text-sm text-red-600 font-semibold hover:text-red-800 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="text-blue-600 font-semibold">Login</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
