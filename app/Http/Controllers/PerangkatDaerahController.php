<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perangkat_Daerah;
use Illuminate\Validation\Validator;

class PerangkatDaerahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perangkat_daerahs = Perangkat_Daerah::orderBy('id', 'asc')->get();
        return view('admin.perangkat_daerah.index', compact('perangkat_daerahs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.perangkat_daerah.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate request data
        $validatedData = $request->validate(
            [
                'perangkat_daerah' => 'required|string|max:255',
                'singkatan' => 'nullable|string|max:255'
            ],
            [
                'perangkat_daerah.required' => 'The item perangkat_daerah is required',
                'singkatan.string' => 'The singkatan must be string'
            ]
        );

        // Save the item to the database
        $perangkat_daerah = Perangkat_Daerah::create($validatedData);

        // Redirect to the perangkat daerah index with success message
        return redirect()->route('perangkat_daerah.index')
            ->with('success', 'Perangkat Daerah Berhasil Ditambahkan');

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
        $perangkat_daerah = Perangkat_Daerah::findOrFail($id);
        $perangkat_daerahs = Perangkat_Daerah::orderBy('id', 'asc')->get();
        return view('admin.perangkat_daerah.edit', compact('perangkat_daerah', 'perangkat_daerahs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate request data
        $validatedData = $request->validate(
            [
                'perangkat_daerah' => 'required|string|max:255',
                'singkatan' => 'nullable|string|max:255'
            ],
            [
                'perangkat_daerah.required' => 'The item perangkat_daerah is required',
                'singkatan.string' => 'The singkatan must be string'
            ]
        );

        // Find the item and update it
        $perangkat_daerah = Perangkat_Daerah::findOrFail($id);
        $perangkat_daerah->update($validatedData);

        // Redirect to the perangkat daerah index with success message
        return redirect()->route('perangkat_daerah.index')
            ->with('success', ' Perangkat Daerah Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $perangkat_daerah = Perangkat_Daerah::findOrFail($id);
        $perangkat_daerah->delete();

        return redirect()->route('perangkat_daerah.index')
            ->with('success', ' Perangkat Daerah Berhasil Dihapus');

    }
}
