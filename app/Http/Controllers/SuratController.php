<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Surat;
use App\Models\PerangkatDaerah;
use App\Models\Jabatan;


class SuratController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role->role_name === 'User') {
            // User hanya lihat surat miliknya (berdasarkan perangkat daerah)
            $surats = Surat::where('id_perangkat_daerah', $user->id_perangkat_daerah)->get();
        } else {
            // Admin lihat semua surat
            $surats = Surat::all();
        }

        return view('admin.surat.index', compact('surats'));
    }

    public function create()
    {
        $user = auth()->user();

        if ($user->role->role_name === 'User') {
            // user biasa hanya bisa pilih perangkat daerahnya sendiri
            $perangkatDaerah = collect([$user->perangkatDaerah]);
            $jabatans = \App\Models\Jabatan::where('id_perangkat_daerah', $user->id_perangkat_daerah)->get();
        } else {
            // admin bisa lihat semua
            $perangkatDaerah = \App\Models\PerangkatDaerah::all();
            $jabatans = collect(); // akan diisi lewat AJAX
        }

        return view('admin.surat.create', compact('perangkatDaerah', 'jabatans', 'user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'asal_surat' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat',
            'perihal' => 'required|string',
            'tanggal_surat' => 'nullable|date',
            'tanggal_terima' => 'nullable|date',
            'sifat_surat' => 'required',
            'hal' => 'required|string',
            'id_perangkat_daerah' => 'required|exists:perangkat_daerahs,id',
            'id_jabatan' => 'required|exists:jabatans,id',
        ], [
            'nomor_surat.unique' => 'Nomor surat ini sudah terdaftar, silakan gunakan nomor lain.',
        ]);

        // Default tanggal jika kosong
        $validatedData['tanggal_surat'] = $validatedData['tanggal_surat'] ?? now();

        // Set otomatis perangkat daerah untuk user biasa
        if ($user->role->role_name === 'User') {
            $validatedData['id_perangkat_daerah'] = $user->id_perangkat_daerah;
        }

        // Upload file jika ada
        if ($request->hasFile('file_surat')) {
            $validatedData['file_surat'] = $request->file('file_surat')->store('surat', 'public');
        }

        Surat::create($validatedData);

        return redirect()->route('surat.index')->with('success', ' Surat berhasil ditambahkan!');
    }



    public function show($id)
    {
        $user = auth()->user();
        $surat = Surat::findOrFail($id);

        if (
            $user->role->role_name === 'User' &&
            $surat->id_perangkat_daerah !== $user->id_perangkat_daerah
        ) {
            abort(403, 'Anda tidak memiliki akses ke surat ini.');
        }

        return view('admin.surat.show', compact('surat'));
    }

    public function edit($id)
    {
        $surat = Surat::findOrFail($id);
        $perangkatDaerah = PerangkatDaerah::all();
        $jabatans = Jabatan::where('id_perangkat_daerah', $surat->id_perangkat_daerah)->get();

        return view('admin.surat.edit', compact('surat', 'perangkatDaerah', 'jabatans'));
    }

    /**
     * Proses update data surat.
     */
    public function update(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);
        $user = auth()->user();

        $validatedData = $request->validate([
            'asal_surat' => 'required|string|max:255',
            'nomor_surat' => 'required|string|max:255|unique:surats,nomor_surat,' . $surat->id,
            'perihal' => 'required|string',
            'tanggal_surat' => 'nullable|date',
            'tanggal_terima' => 'nullable|date',
            'sifat_surat' => 'required',
            'hal' => 'required|string',
            'id_perangkat_daerah' => 'required|exists:perangkat_daerahs,id',
            'id_jabatan' => 'required|exists:jabatans,id',
        ], [
            'nomor_surat.unique' => 'Nomor surat ini sudah digunakan surat lain.',
        ]);

        // Default tanggal jika kosong
        $validatedData['tanggal_surat'] = $validatedData['tanggal_surat'] ?? now();

        // Jika user biasa, perangkat daerah otomatis dari user login
        if ($user->role->role_name === 'User') {
            $validatedData['id_perangkat_daerah'] = $user->id_perangkat_daerah;
        }

        // Upload file baru jika ada, dan hapus file lama
        if ($request->hasFile('file_surat')) {
            if ($surat->file_surat && \Storage::disk('public')->exists($surat->file_surat)) {
                \Storage::disk('public')->delete($surat->file_surat);
            }
            $validatedData['file_surat'] = $request->file('file_surat')->store('surat', 'public');
        }

        $surat->update($validatedData);

        return redirect()->route('surat.index')->with('success', ' Data surat berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $surat = Surat::findOrFail($id);

        // Hapus file jika ada (opsional, kalau kamu menyimpan file surat)
        if ($surat->file_surat && \Storage::disk('public')->exists($surat->file_surat)) {
            \Storage::disk('public')->delete($surat->file_surat);
        }

        $surat->delete();

        return redirect()->route('surat.index')->with('success', ' Data surat berhasil dihapus!');
    }


    // fungsi create, store, edit, update, destroy tetap sama (hanya admin yang bisa karena route-nya sudah diatur middleware)
}
