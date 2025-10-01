<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jabatan;
use App\Models\Perangkat_Daerah;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatans = Jabatan::all();
        return view('admin.jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perangkat_daerah = Perangkat_Daerah::all();
        return view('admin.jabatan.create', compact('perangkat_daerah'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'id_perangkat_daerah' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                // 'prioritas' => 'required',
            ],

            [
                'id_perangkat_daerah.required' => 'Perangkat Daerah wajib diisi.',
                'jabatan.required' => 'Jabatan wajib diisi.',
                // 'prioritas.required' => 'Prioritas wajib diisi.',
            ]
        );

        $Jabatan = Jabatan::create($validatedData);

        return redirect()->route('jabatan.index')
            ->with('success', ' Jabatan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $perangkat_daerah = Perangkat_Daerah::all();
        return view('admin.jabatan.edit', compact('jabatan', 'perangkat_daerah'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate(
            [
                'id_perangkat_daerah' => 'required|string|max:255',
                'jabatan' => 'required|string|max:255',
                // 'prioritas' => 'required',
            ],

            [
                'id_perangkat_daerah.required' => 'Perangkat Daerah wajib diisi.',
                'jabatan.required' => 'Jabatan wajib diisi.',
                // 'prioritas.required' => 'Prioritas wajib diisi.',
            ]
        );

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($validatedData);

        return redirect()->route('jabatan.index')
            ->with('success', ' Jabatan berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jabatan = Jabatan::findOrFail($id);
        $jabatan->delete();

        return redirect()->route('jabatan.index')
            ->with('success', ' Jabatan Berhasil Dihapus');
    }
}
