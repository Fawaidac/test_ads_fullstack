<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index()
    {
        $karyawan = Karyawan::all();
        return view('layouts.pages.karyawan', compact('karyawan'));
    }

    public function show($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return response()->json($karyawan);
    }

    public function edit($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        return response()->json($karyawan);
    }


    public function create()
    {
        return view('karyawan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_induk' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
        ]);

        Karyawan::create($validated);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }



    public function update(Request $request, $id)
    {
        $karyawan = Karyawan::findOrFail($id);

        $validated = $request->validate([
            'nomor_induk' => 'required|unique:karyawans,nomor_induk,' . $id,
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
        ]);

        $karyawan->update($validated);
        return redirect()->route('karyawan.index');
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::findOrFail($id);
        $karyawan->delete();
        return redirect()->route('karyawan.index');
    }
}
