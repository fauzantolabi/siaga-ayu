<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\PerangkatDaerah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <-- PENTING: Tambahkan ini

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        if ($user->role->role_name === 'Admin') {
            // Jika ADMIN, tampilkan semua jabatan dari semua instansi
            $jabatans = Jabatan::with('perangkatDaerah')
                ->latest()
                ->get();
        } else {
            // Jika USER, hanya tampilkan jabatan dari perangkat daerahnya sendiri
            $userPerangkatDaerahId = $user->id_perangkat_daerah;
            $jabatans = Jabatan::with('perangkatDaerah')
                ->where('id_perangkat_daerah', $userPerangkatDaerahId)
                ->latest()
                ->get();
        }

        return view('admin.jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->role->role_name === 'Admin') {
            // Admin bisa melihat semua perangkat daerah
            $perangkatDaerah = PerangkatDaerah::all();
        } else {
            // User hanya bisa melihat perangkat daerahnya sendiri
            $perangkatDaerah = PerangkatDaerah::where('id', $user->id_perangkat_daerah)->get();
        }

        return view('admin.jabatan.create', compact('perangkatDaerah'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi input dasar
        $validatedData = $request->validate([
            'id_perangkat_daerah' => 'required|exists:perangkat_daerahs,id',
            'jabatan' => 'required|string|max:255',
        ]);

        // 🔍 Cek apakah jabatan sudah ada di perangkat daerah tersebut
        $cekJabatan = Jabatan::where('id_perangkat_daerah', $validatedData['id_perangkat_daerah'])
            ->whereRaw('LOWER(jabatan) = ?', [strtolower($validatedData['jabatan'])])
            ->first();

        if ($cekJabatan) {
            return redirect()->back()
                ->withErrors(['jabatan' => 'Jabatan ini sudah ada pada perangkat daerah tersebut.'])
                ->withInput();
        }

        // 👮‍♂️ Jika User (bukan admin), pastikan hanya bisa menambah di perangkat daerahnya sendiri
        if ($user->role->role_name !== 'Admin' && $validatedData['id_perangkat_daerah'] != $user->id_perangkat_daerah) {
            abort(403, 'Anda tidak diizinkan menambahkan jabatan di perangkat daerah lain.');
        }

        // Simpan data
        Jabatan::create($validatedData);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil ditambahkan.');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $user = Auth::user();

        // ✅ Cek otorisasi hanya untuk User biasa
        if ($user->role->role_name !== 'Admin' && $jabatan->id_perangkat_daerah != $user->id_perangkat_daerah) {
            abort(403, 'AKSI TIDAK DIIZINKAN.');
        }

        // ✅ Admin bisa pilih semua perangkat daerah
        if ($user->role->role_name === 'Admin') {
            $perangkatDaerah = \App\Models\PerangkatDaerah::orderBy('perangkat_daerah')->get();
        } else {
            // User hanya bisa pilih perangkat daerahnya sendiri
            $perangkatDaerah = \App\Models\PerangkatDaerah::where('id', $user->id_perangkat_daerah)->get();
        }

        return view('admin.jabatan.edit', compact('jabatan', 'perangkatDaerah'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = Auth::user();
        $jabatan = Jabatan::findOrFail($id);

        // Validasi dasar
        $validatedData = $request->validate([
            'id_perangkat_daerah' => 'required|exists:perangkat_daerahs,id',
            'jabatan' => 'required|string|max:255',
        ]);

        // 👮‍♂️ Jika user biasa, pastikan hanya ubah jabatan di perangkat daerahnya sendiri
        if ($user->role->role_name !== 'Admin' && $jabatan->id_perangkat_daerah != $user->id_perangkat_daerah) {
            abort(403, 'Anda tidak diizinkan mengubah jabatan di perangkat daerah lain.');
        }

        // 🔍 Cek apakah jabatan dengan nama yang sama sudah ada di perangkat daerah tersebut (kecuali dirinya sendiri)
        $cekJabatan = Jabatan::where('id_perangkat_daerah', $validatedData['id_perangkat_daerah'])
            ->whereRaw('LOWER(jabatan) = ?', [strtolower($validatedData['jabatan'])])
            ->where('id', '!=', $jabatan->id)
            ->first();

        if ($cekJabatan) {
            return redirect()->back()
                ->withErrors(['jabatan' => 'Jabatan ini sudah ada pada perangkat daerah tersebut.'])
                ->withInput();
        }

        // Update data
        $jabatan->update($validatedData);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil diperbarui.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);

        // Langsung hapus tanpa cek role
        $jabatan->delete();

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil dihapus.');
    }

    /**
     * API endpoint to get Jabatans by Perangkat Daerah ID.
     * This is useful for AJAX calls.
     */
    public function getByPerangkatDaerah($id)
    {
        $jabatans = \App\Models\Jabatan::where('id_perangkat_daerah', $id)
            ->select('id', 'jabatan')
            ->orderBy('jabatan')
            ->get();

        return response()->json($jabatans);
    }



}

