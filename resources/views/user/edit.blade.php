<x-app-layout>

    <div class="max-w-md mx-auto">

        <h1 class="text-2xl font-bold mb-6">Edit User</h1>

        <form action="{{ route('user.update', $user->id) }}" method="POST"
              class="bg-white p-6 shadow rounded-xl">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="font-semibold">Nama</label>
                <input type="text" name="name" value="{{ $user->name }}"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Role</label>
                <select name="role" class="w-full border rounded-lg p-2" required>
                    <option value="pelanggan" {{ $user->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                    <option value="karyawan" {{ $user->role == 'karyawan' ? 'selected' : '' }}>Karyawan</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Email</label>
                <input type="email" name="email" value="{{ $user->email }}"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div class="mb-4">
                <label class="font-semibold">Password Baru (opsional)</label>
                <input type="password" name="password"
                       class="w-full border rounded-lg p-2">
            </div>

            <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                Update
            </button>
        </form>

    </div>

</x-app-layout>
