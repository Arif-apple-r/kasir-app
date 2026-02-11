<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = User::where('role', 'karyawan')->get();

        return view('karyawan.index', compact('karyawan'));
    }

    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5'
        ]);

        User::create([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => 'karyawan',
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    public function edit($id)
    {
        $karyawan = User::findOrFail($id);

        return view('karyawan.edit', compact('karyawan'));
    }

    public function update(Request $request, $id)
    {
        $karyawan = User::findOrFail($id);

        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        $karyawan->name = $request->name;
        $karyawan->email = $request->email;

        if ($request->filled('password')) {
            $karyawan->password = Hash::make($request->password);
        }

        $karyawan->save();

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan diperbarui');
    }

    public function destroy($id)
    {
        User::destroy($id);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan dihapus');
    }
}
