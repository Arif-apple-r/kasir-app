<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100">
    {{-- ========== NAVBAR UNTUK PELANGGAN & GUEST ========== --}}
    @if(!Auth::check() || Auth::user()->role === 'pelanggan')
        @include('layouts.partials.pelangganNavbar')
    @endif

    {{-- ========== END NAVBAR ========== --}}
    <div class="min-h-screen flex">
        {{-- ========== SIDEBAR ADMIN ========== --}}
        @if(Auth::check() && Auth::user()->role === 'admin')
            @include('layouts.partials.adminsidebar')
        @endif
        @if(Auth::check() && Auth::user()->role === 'karyawan')
            @include('layouts.partials.karyawansidebar')
        @endif
        {{-- ========== END SIDEBAR ========== --}}

        {{-- ========== MAIN CONTENT ========== --}}
        <main class="flex-1 p-8">
            {{ $slot }}
        </main>
    </div>

    

    <!-- LOGOUT MODAL -->
    <div id="logoutModal"
        class="fixed inset-0 hidden flex items-center justify-center
                bg-black/50 backdrop-blur-sm z-50">

        <div id="logoutCard"
            class="bg-white w-full max-w-sm mx-4 rounded-2xl shadow-2xl
                    p-8 text-center transform scale-95 opacity-0 transition duration-200">

            <!-- Icon -->
            <div class="mx-auto mb-4 flex items-center justify-center
                        w-16 h-16 rounded-full bg-red-100">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0
                        2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46
                        0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                </svg>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-2">
                Logout Akun?
            </h2>

            <p class="text-gray-600 mb-6">
                Kamu yakin ingin keluar dari akun ini?
            </p>

            <div class="flex justify-center gap-3">
                <button onclick="closeLogoutModal()"
                    class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition font-medium">
                    Batal
                </button>

                <button onclick="confirmLogout()"
                    class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition font-medium shadow">
                    Ya, Logout
                </button>
            </div>
        </div>
    </div>

    <!-- UNIVERSAL DELETE MODAL -->
    <div id="deleteModal"
        class="fixed inset-0 hidden flex items-center justify-center
                bg-black/50 backdrop-blur-sm z-50">

        <div id="deleteCard"
            class="bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl
                    p-8 text-center transform scale-95 opacity-0 transition duration-200">

            <div class="mx-auto mb-4 flex items-center justify-center
                        w-16 h-16 rounded-full bg-red-100">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M5.07 19h13.86c1.54 0
                        2.5-1.67 1.73-3L13.73 4c-.77-1.33-2.69-1.33-3.46
                        0L3.34 16c-.77 1.33.19 3 1.73 3z"/>
                </svg>
            </div>

            <h2 class="text-xl font-bold text-gray-800 mb-2">
                Hapus Data?
            </h2>

            <p class="text-gray-600 mb-6">
                Data <span id="deleteItemName" class="font-semibold text-red-600"></span> akan dihapus permanen.
            </p>

            <div class="flex justify-center gap-3">
                <button onclick="closeDeleteModal()"
                    class="px-5 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 transition font-medium">
                    Batal
                </button>

                <button onclick="confirmDelete()"
                    class="px-5 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white transition font-medium shadow">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </div>


    <script>
        let logoutForm = null;

        function openLogoutModal(button) {
            logoutForm = button.closest("form");

            const modal = document.getElementById("logoutModal");
            const card = document.getElementById("logoutCard");

            modal.classList.remove("hidden");

            // animasi hanya saat buka
            setTimeout(() => {
                card.classList.remove("scale-95", "opacity-0");
                card.classList.add("scale-100", "opacity-100");
            }, 10);
        }

        function closeLogoutModal() {
            const modal = document.getElementById("logoutModal");
            const card = document.getElementById("logoutCard");

            // langsung reset tanpa delay
            card.classList.remove("scale-100", "opacity-100");
            card.classList.add("scale-95", "opacity-0");

            modal.classList.add("hidden");
        }

        function confirmLogout() {
            if (logoutForm) {
                logoutForm.submit();
            }
        }

        // klik area gelap untuk close
        document.getElementById("logoutModal").addEventListener("click", function(e) {
            if (e.target === this) {
                closeLogoutModal();
            }
        });

        let deleteForm = null;

        function openDeleteModal(button) {
            deleteForm = button.closest("form");

            const modal = document.getElementById("deleteModal");
            const card = document.getElementById("deleteCard");
            const name = button.getAttribute("data-name");

            document.getElementById("deleteItemName").textContent = name ?? "";

            modal.classList.remove("hidden");

            setTimeout(() => {
                card.classList.remove("scale-95", "opacity-0");
                card.classList.add("scale-100", "opacity-100");
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById("deleteModal");
            const card = document.getElementById("deleteCard");

            card.classList.remove("scale-100", "opacity-100");
            card.classList.add("scale-95", "opacity-0");

            modal.classList.add("hidden");
        }

        function confirmDelete() {
            if (deleteForm) {
                deleteForm.submit();
            }
        }

        document.getElementById("deleteModal").addEventListener("click", function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>
</body>
</html>
