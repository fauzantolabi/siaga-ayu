<?php

namespace App\Http\Controllers;

use App\Models\Misi;
use Illuminate\Http\Request;

class MisiController extends Controller
{
    public function index()
    {
        $misis = Misi::withCount('programs')->latest()->get();
        return view('admin.misi.index', compact('misis'));
    }

    public function create()
    {
        return view('admin.misi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'misi' => 'required|string|max:255|unique:misis,misi',
            'description' => 'nullable|string',
        ]);

        Misi::create($validated);

        return redirect()->route('misi.index')->with('success', 'Misi berhasil ditambahkan.');
    }

    public function edit(Misi $misi)
    {
        return view('misi.edit', compact('misi'));
    }

    public function update(Request $request, Misi $misi)
    {
        $validated = $request->validate([
            'misi' => 'required|string|max:255|unique:misis,misi,' . $misi->id,
            'description' => 'nullable|string',
        ]);

        $misi->update($validated);

        return redirect()->route('misi.index')->with('success', 'Misi berhasil diperbarui.');
    }

    public function destroy(Misi $misi)
    {
        $misi->delete();
        return redirect()->route('misi.index')->with('success', 'Misi berhasil dihapus.');
    }
}
