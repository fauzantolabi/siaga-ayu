<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Jabatan;
use App\Models\Pakaian;
use App\Models\Surat;
use App\Models\AgendaPhoto;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendas = Agenda::with('jabatan')->nearest()->get();
        return view('admin.agenda.index', compact('agendas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $surat = Surat::all();
        $pakaian = Pakaian::all();
        $jabatan = Jabatan::all();

        return view('admin.agenda.create', compact('surat', 'pakaian', 'jabatan'));
    }

    public function createBySurat($surat_id)
    {
        $surat = Surat::findOrFail($surat_id);
        $pakaian = Pakaian::all();
        $jabatan = Jabatan::all();

        return view('admin.agenda.create', compact('surat', 'pakaian', 'jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_surat' => 'required|exists:surats,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tempat' => 'required|string|max:255',
            'agenda' => 'required|string|max:255',
            'id_pakaian' => 'nullable|exists:pakaians,id',
            'id_jabatan' => 'nullable|exists:jabatans,id',
            'id_user' => 'nullable|exists:users,id',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'id_surat.required' => 'Surat wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'waktu.required' => 'Waktu wajib diisi.',
            'tempat.required' => 'Tempat wajib diisi.',
            'agenda.required' => 'Nama agenda wajib diisi.',
        ]);

        // Simpan data utama agenda
        $agenda = Agenda::create($validatedData);

        // Upload beberapa foto (jika ada)
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                $path = $file->store('agenda_foto', 'public');
                $agenda->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agenda = Agenda::with('photos')->findOrFail($id);
        $pakaian = Pakaian::all();
        $jabatan = Jabatan::all();
        $surat = Surat::all();

        return view('admin.agenda.edit', compact('agenda', 'pakaian', 'jabatan', 'surat'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $agenda = Agenda::findOrFail($id);

        $validatedData = $request->validate([
            'id_surat' => 'required|exists:surats,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'agenda' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'id_jabatan' => 'nullable|exists:jabatans,id',
            'id_pakaian' => 'nullable|exists:pakaians,id',
            'resume' => 'nullable|string',
            'hapus_foto.*' => 'nullable|exists:agenda_photos,id',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update data utama
        $agenda->update($validatedData);

        // Hapus foto yang dicentang
        if ($request->filled('hapus_foto')) {
            foreach ($request->hapus_foto as $fotoId) {
                $foto = $agenda->photos()->find($fotoId);
                if ($foto) {
                    if (file_exists(storage_path('app/public/' . $foto->path))) {
                        unlink(storage_path('app/public/' . $foto->path));
                    }
                    $foto->delete();
                }
            }
        }

        // Upload foto baru
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                $path = $file->store('agenda_foto', 'public');
                $agenda->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('agenda.index')->with('success', 'Agenda berhasil dihapus.');
    }
}
