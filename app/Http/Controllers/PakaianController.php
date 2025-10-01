<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pakaian;
use Illuminate\Validation\Validator;

class PakaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pakaian = Pakaian::all();
        return view('admin.pakaian.index', compact('pakaian'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pakaian.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate request data
        $validatedData = $request->validate(
            [
                'pakaian' => 'required|string|max:255',
                'singkatan' => 'nullable|string|max:255'
            ],
            [
                'pakaian.required' => 'The item pakaian is required',
                'singkatan.string' => 'The singkatan must be string'
            ]
        );

        // Save the item to the database
        $pakaian = Pakaian::create($validatedData);

        // Redirect to the perangkat daerah index with success message
        return redirect()->route('pakaian.index')
            ->with('success', ' Pakaian Berhasil Ditambahkan');

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
        $pakaian = Pakaian::findOrFail($id);
        return view('admin.pakaian.edit', compact('pakaian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate request data
        $validatedData = $request->validate(
            [
                'pakaian' => 'required|string|max:255',
                'singkatan' => 'nullable|string|max:255'
            ],
            [
                'pakaian.required' => 'The item pakaian is required',
                'singkatan.string' => 'The singkatan must be string'
            ]
        );

        // Find the existing item
        $pakaian = Pakaian::findOrFail($id);

        // Update the item with validated data
        $pakaian->update($validatedData);

        // Redirect to the index with success message
        return redirect()->route('pakaian.index')
            ->with('success', ' Pakaian Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pakaian = Pakaian::findOrFail($id);
        $pakaian->delete();

        return redirect()->route('pakaian.index')
            ->with('success', ' Pakaian Berhasil Dihapus');
    }
}
