<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Jabatan;
use App\Models\Pakaian;
use App\Models\Surat;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agendas = \App\Models\Agenda::with('jabatan')
            ->nearest() // pakai scope
            ->get();

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
        // $surat = Surat::all();
        $pakaian = Pakaian::all();
        $jabatan = Jabatan::all();

        return view('admin.agenda.create', compact('surat', 'pakaian', 'jabatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'id_surat' => 'required|exists:surats,id',
                'tanggal' => 'required|date',
                'waktu' => 'required',
                'tempat' => 'required|string|max:255',
                'agenda' => 'required|string|max:255',
                'id_pakaian' => 'nullable|exists:pakaians,id',
                'id_jabatan' => 'nullable|exists:jabatans,id',
                'id_user' => 'nullable|exists:users,id',
            ],
            [
                'id_surat.required' => 'Surat wajib diisi.',
                'id_surat.exists' => 'Surat tidak ditemukan dalam database.',
                'tanggal.required' => 'Tanggal wajib diisi.',
                'tanggal.date' => 'Format tanggal tidak valid.',
                'waktu.required' => 'Jam wajib diisi.',
                'tempat.required' => 'Tempat wajib diisi.',
                'agenda.required' => 'Nama agenda wajib diisi.',
            ]
        );

        Agenda::create($validatedData);

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $agenda = Agenda::findOrFail($id);
        $pakaian = Pakaian::all();
        $jabatan = Jabatan::all();
        $surat = Surat::all(); // tampilkan semua surat untuk dropdown

        return view('admin.agenda.edit', compact('agenda', 'pakaian', 'jabatan', 'surat'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'id_surat' => 'required|exists:surats,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'agenda' => 'required|string|max:255',
            'tempat' => 'required|string|max:255',
            'id_jabatan' => 'nullable|exists:jabatans,id',
            'id_pakaian' => 'nullable|exists:pakaians,id',
            'resume' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'id_surat.required' => 'Surat wajib dipilih.',
            'id_surat.exists' => 'Surat tidak ditemukan.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.date' => 'Format tanggal tidak valid.',
            'waktu.required' => 'Waktu wajib diisi.',
            'agenda.required' => 'Agenda wajib diisi.',
            'tempat.required' => 'Tempat wajib diisi.',
        ]);

        $agenda = Agenda::findOrFail($id);

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $path = $file->store('agenda_foto', 'public'); // simpan di storage/app/public/agenda_foto
            $validatedData['foto'] = $path;
        }

        $agenda->update($validatedData);

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', 'Agenda berhasil dihapus.');
    }
}
