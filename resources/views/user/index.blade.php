<x-app-layout>

    <div class="max-w-5xl mx-auto">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold">Daftar User</h1>

            <a href="{{ route('user.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                + Tambah User
            </a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 border border-green-300 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-xl p-6">

            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100 text-gray-600">
                        <th class="py-2 px-3 text-left">Nama</th>
                        <th class="py-2 px-3 text-left">Email</th>
                        <th class="py-2 px-3 text-left">Role</th>
                        <th class="py-2 px-3 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($users as $u)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-2 px-3">{{ $u->name }}</td>
                        <td class="py-2 px-3">{{ $u->email }}</td>
                        <td class="py-4 px-4">
                                    {{-- Badge Role dengan warna hierarki --}}
                                    @if($u->role == 'admin')
                                        <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-bold border border-purple-200">
                                            👑 ADMIN
                                        </span>
                                    @elseif($u->role == 'karyawan')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-bold border border-blue-200">
                                            🛠️ KARYAWAN
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-bold border border-gray-200">
                                            👤 PELANGGAN
                                        </span>
                                    @endif
                        </td>
                        <td class="py-2 px-3">
                            <div class="flex space-x-2">

                                <a href="{{ route('user.edit', $u->id) }}"
                                   class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                    Edit
                                </a>

                                <form action="{{ route('user.destroy', $u->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin mau hapus?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">
                                        Hapus
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>

</x-app-layout>
