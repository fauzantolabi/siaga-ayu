<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Jabatan;
use App\Models\Pakaian;
use App\Models\Surat;
use App\Models\PerangkatDaerah;

class AgendaController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role->role_name === 'User') {
            // User hanya melihat agenda dari perangkat daerahnya sendiri
            $agendas = \App\Models\Agenda::with(['jabatan', 'perangkatDaerah'])
                ->whereHas('jabatan', function ($q) use ($user) {
                    $q->where('id_perangkat_daerah', $user->id_perangkat_daerah);
                })
                ->get();
        } else {
            // Admin melihat semua agenda
            // $agendas = \App\Models\Agenda::with(['jabatan', 'perangkatDaerah'])->get();
            $agendas = Agenda::with(['jabatan', 'pakaian', 'surat'])
                ->join('jabatans', 'agendas.id_jabatan', '=', 'jabatans.id')
                ->orderBy('jabatans.prioritas', 'asc') // semakin kecil = jabatan lebih tinggi
                ->select('agendas.*')
                ->get();
        }

        return view('admin.agenda.index', compact('agendas'));
    }


    // Menampilkan form create umum (tanpa preselected surat)
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
        $surats = Surat::all();
        $pakaian = Pakaian::all();
        $selectedSurat = null; // tidak ada yang dipilih

        return view('admin.agenda.create', compact('surats', 'pakaian', 'jabatans', 'selectedSurat'));
    }

    // Menampilkan form create ketika dipanggil dari surat tertentu
    // (route model binding; route harus punya param {surat})
    public function createBySurat(Surat $surat)
    {
        $user = auth()->user();

        if ($user->role->role_name === 'User') {
            // User biasa hanya bisa pilih perangkat daerahnya sendiri
            $perangkatDaerah = collect([$user->perangkatDaerah]);
            $jabatans = \App\Models\Jabatan::where('id_perangkat_daerah', $user->id_perangkat_daerah)->get();
        } else {
            // Admin bisa lihat semua
            $perangkatDaerah = \App\Models\PerangkatDaerah::all();
            $jabatans = collect(); // akan diisi lewat AJAX
        }

        $surats = \App\Models\Surat::all();
        $pakaian = \App\Models\Pakaian::all();
        $selectedSurat = $surat; // surat yang dipilih

        return view('admin.agenda.create', compact(
            'surats',
            'pakaian',
            'jabatans',
            'selectedSurat',
            'perangkatDaerah' // 🔥 tambahkan ini
        ));
    }



    public function store(Request $request)
    {
        $user = auth()->user();

        // Validasi dasar
        $validatedData = $request->validate([
            'id_surat' => 'required|exists:surats,id',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tempat' => 'required|string|max:255',
            'agenda' => 'required|string|max:255',
            'id_pakaian' => 'nullable|exists:pakaians,id',
            'id_jabatan' => 'nullable|exists:jabatans,id',
            'id_user' => 'nullable|exists:users,id',
        ]);

        // Ambil surat terkait
        $surat = \App\Models\Surat::findOrFail($validatedData['id_surat']);

        // Jika role user biasa, pastikan surat miliknya
        if ($user->role->role_name === 'User' && $surat->id_perangkat_daerah !== $user->id_perangkat_daerah) {
            return redirect()->back()->withErrors(['id_surat' => 'Anda tidak memiliki akses ke surat ini.']);
        }

        // Validasi: jabatan harus dari perangkat daerah surat
        $jabatan = \App\Models\Jabatan::findOrFail($validatedData['id_jabatan']);

        if ($user->role->role_name === 'User') {
            if ($jabatan->id_perangkat_daerah != $surat->id_perangkat_daerah) {
                return redirect()->back()
                    ->withErrors(['id_jabatan' => 'Jabatan tidak sesuai dengan perangkat daerah surat Anda.']);
            }
        }

        // if ($request->hasFile('fotos')) {
        //     foreach ($request->file('fotos') as $file) {
        //         $path = $file->store('agenda_foto', 'public');
        //         $agenda->photos()->create(['path' => $path]);
        //     }
        // }
        Agenda::create($validatedData);


        return redirect()->route('agenda.index')->with('success', ' Agenda berhasil dibuat!');
    }



    public function show($id)
    {
        $agenda = Agenda::with(['jabatan.perangkatDaerah', 'pakaian', 'surat'])->findOrFail($id);
        $user = auth()->user();

        if (
            $user->role->role_name === 'User' &&
            $agenda->jabatan->perangkatDaerah->id !== $user->id_perangkat_daerah
        ) {
            abort(403, 'Anda tidak memiliki akses ke agenda ini.');
        }

        return view('admin.agenda.show', compact('agenda'));
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);
        $user = auth()->user();

        // Data umum
        $pakaian = Pakaian::all();
        $surats = Surat::all();
        $perangkatDaerahs = PerangkatDaerah::all();

        // Ambil jabatan sesuai role
        if ($user->role->role_name === 'User') {
            // user cuma melihat/menyeleksi jabatan dari perangkat daerah miliknya
            $jabatans = Jabatan::where('id_perangkat_daerah', $user->id_perangkat_daerah)->get();
        } else {
            // admin dapat melihat semua jabatan (atau bisa kosong jika mau pakai AJAX)
            $jabatans = Jabatan::all();
        }

        // Surat yang terkait dengan agenda (dipakai untuk menampilkan selected surat)
        $selectedSurat = $agenda->surat ?? null;

        return view('admin.agenda.edit', compact(
            'agenda',
            'pakaian',
            'jabatans',
            'surats',
            'perangkatDaerahs',
            'selectedSurat'
        ));
    }



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

        // Hapus foto yang dipilih
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

        // Tambah foto baru
        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $file) {
                $path = $file->store('agenda_foto', 'public');
                $agenda->photos()->create(['path' => $path]);
            }
        }

        return redirect()->route('agenda.index')->with('success', ' Agenda berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', ' Agenda berhasil dihapus.');
    }
}
