<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Mulai Bisnis Anda</h2>
        <p class="text-gray-500 text-sm mt-2">Daftar akun KasirCihuy! hari ini</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="space-y-4">
            <div>
                <label class="block font-semibold text-sm text-gray-700">Nama Lengkap</label>
                <input id="name" type="text" name="name" :value="old('name')" required
                       class="block mt-1 w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm p-3 @error('name') border-red-500 @enderror">
                @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block font-semibold text-sm text-gray-700">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required
                       class="block mt-1 w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm p-3 @error('email') border-red-500 @enderror">
                @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-semibold text-sm text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                           class="block mt-1 w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm p-3 @error('password') border-red-500 @enderror">
                    @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block font-semibold text-sm text-gray-700">Konfirmasi</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                           class="block mt-1 w-full border-gray-200 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm p-3 @error('password_confirmation') border-red-500 @enderror">
                    @error('password_confirmation')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>
        </div>

        <div class="mt-8">
            <button class="w-full py-3.5 px-4 bg-gray-900 hover:bg-black text-white font-bold rounded-xl transition duration-200 shadow-lg transform hover:-translate-y-0.5">
                Buat Akun Sekarang
            </button>
        </div>

        <p class="mt-8 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a class="font-bold text-blue-600 hover:text-blue-500 underline" href="{{ route('login') }}">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
