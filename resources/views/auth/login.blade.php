<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang Kembali</h2>
        <p class="text-gray-500 text-sm mt-2">Masuk ke dashboard KasirCihuy! Anda</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label class="block font-semibold text-sm text-gray-700">Email Address</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                   class="block mt-1 w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm p-3 transition">
        </div>

        <div class="mt-5">
            <label class="block font-semibold text-sm text-gray-700">Password</label>
            <input id="password" type="password" name="password" required
                   class="block mt-1 w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm p-3 transition">
        </div>

        <div class="flex items-center justify-between mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                <span class="ms-2 text-sm text-gray-600">Ingat saya</span>
            </label>
        </div>

        <div class="mt-8">
            <button class="w-full py-3.5 px-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition duration-200 shadow-lg shadow-blue-200 transform hover:-translate-y-0.5">
                Masuk Sekarang
            </button>
        </div>

        <p class="mt-8 text-center text-sm text-gray-600">
            Belum punya akun?
            <a class="font-bold text-blue-600 hover:text-blue-500 underline" href="{{ route('register') }}">Daftar Gratis</a>
        </p>
    </form>
</x-guest-layout>
