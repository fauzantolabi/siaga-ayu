<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surats = Surat::all();
        return view('admin.surat.index', compact('surats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.surat.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'nomor_surat' => 'required|unique:surats,nomor_surat',
                'asal_surat' => 'required|string|max:255',
                'tanggal_surat' => 'required|date',
                'tanggal_terima' => 'nullable|date',
                'perihal' => 'nullable|string|max:255',
                'sifat_surat' => 'nullable|string|max:255',
                'hal' => 'required|string',
            ],
            [
                'nomor_surat.required' => 'Nomor surat wajib diisi.',
                'nomor_surat.unique' => 'Nomor surat sudah ada dalam database.',
                'asal_surat.required' => 'Asal surat wajib diisi.',
                'tanggal_surat.required' => 'Tanggal surat wajib diisi.',
                'tanggal_surat.date' => 'Format tanggal surat tidak valid.',
                'tanggal_terima.date' => 'Format tanggal terima tidak valid.',
                'hal.required' => 'Isi surat wajib diisi.',
            ]
        );
        Surat::create($validatedData);
        return redirect()->route('surat.index')
            ->with('success', ' Surat berhasil ditambahkan.');
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
        $surat = Surat::findOrFail($id);
        return view('admin.surat.edit', compact('surat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'nomor_surat' => 'required|unique:surats,nomor_surat,' . $id,
            'asal_surat' => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'tanggal_terima' => 'nullable|date',
            'perihal' => 'nullable|string|max:255',
            'sifat_surat' => 'nullable|string|max:255',
            'hal' => 'required|string',
        ]);
        $surat = Surat::findOrFail($id);
        $surat->update($validatedData);
        return redirect()->route('surat.index')
            ->with('success', ' Surat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $surat = Surat::findOrFail($id);
        $surat->delete();
        return redirect()->route('surat.index')
            ->with('success', ' Surat berhasil dihapus.');
    }
}
