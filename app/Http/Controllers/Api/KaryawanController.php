<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KaryawanResource;
use App\Http\Resources\KaryawanCollectionResource;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);
        $karyawan = Karyawan::paginate($perPage);
        return new KaryawanCollectionResource($karyawan);
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

        $karyawan = Karyawan::create($validated);
        return new KaryawanResource($karyawan);
    }

    public function show($id)
    {
        $karyawan = Karyawan::find($id);
        if ($karyawan) {
            return new KaryawanResource($karyawan);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Karyawan not found'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nomor_induk' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date',
        ]);

        $karyawan = Karyawan::find($id);
        if ($karyawan) {
            $karyawan->update($validated);
            return new KaryawanResource($karyawan);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Karyawan not found'], 404);
        }
    }

    public function destroy($id)
    {
        $karyawan = Karyawan::find($id);
        if ($karyawan) {
            $karyawan->delete();
            return response()->json(['status' => 'success', 'message' => 'Karyawan deleted successfully']);
        } else {
            return response()->json(['status' => 'error', 'message' => 'Karyawan not found'], 404);
        }
    }

    public function firstJoined()
    {
        $karyawan = Karyawan::orderBy('tanggal_bergabung', 'asc')->take(3)->get();
        return KaryawanResource::collection($karyawan);
    }

    public function withLeave()
    {
        $karyawan = Karyawan::whereHas('cuti')->get();
        return KaryawanResource::collection($karyawan);
    }

    public function remainingLeave()
    {
        $karyawan = Karyawan::all()->map(function ($karyawan) {
            return [
                'nomor_induk' => $karyawan->nomor_induk,
                'nama' => $karyawan->nama,
                'sisa_cuti' => $karyawan->remainingLeave(),
            ];
        });

        return response()->json(['status' => 'success', 'message' => 'Data retrieved successfully', 'data' => $karyawan]);
    }
}
