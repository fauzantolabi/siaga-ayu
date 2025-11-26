<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Misi;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::with('misi')->orderBy('id_misi')->get();
        return view('admin.program.index', compact('programs'));
    }

    public function create()
    {
        $misis = Misi::orderBy('misi')->get();
        return view('admin.program.create', compact('misis'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_misi' => 'required|exists:misis,id',
            'description' => 'required|string|max:255',
        ]);

        // 🔍 Cek apakah program dengan deskripsi yang sama sudah ada di misi tersebut
        $exists = Program::where('id_misi', $validated['id_misi'])
            ->where('description', $validated['description'])
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['description' => 'Program dengan deskripsi ini sudah ada pada Misi yang sama.'])
                ->withInput();
        }

        Program::create($validated);

        return redirect()->route('program.index')->with('success', 'Program berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $misis = Misi::orderBy('misi')->get();
        return view('admin.program.edit', compact('program', 'misis'));
    }

    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $validated = $request->validate([
            'id_misi' => 'required|exists:misis,id',
            'description' => 'required|string|max:255',
        ]);

        // 🔍 Cek apakah duplikasi akan terjadi (kecuali untuk dirinya sendiri)
        $exists = Program::where('id_misi', $validated['id_misi'])
            ->where('description', $validated['description'])
            ->where('id', '!=', $program->id)
            ->exists();

        if ($exists) {
            return back()
                ->withErrors(['description' => 'Program dengan deskripsi ini sudah ada pada Misi yang sama.'])
                ->withInput();
        }

        $program->update($validated);

        return redirect()->route('program.index')->with('success', 'Program berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $program = Program::findOrFail($id);
        $program->delete();

        return redirect()->route('program.index')->with('success', 'Program berhasil dihapus.');
    }

    public function getProgramsByMisi($misiId)
    {
        try {
            $programs = Program::where('id_misi', $misiId)
                ->select('id', 'description')
                ->orderBy('description', 'asc')
                ->get();

            return response()->json($programs);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal memuat data program.'], 500);
        }
    }

}
