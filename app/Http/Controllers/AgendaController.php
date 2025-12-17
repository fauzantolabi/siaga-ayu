<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agenda;
use App\Models\Jabatan;
use App\Models\Pakaian;
use App\Models\Surat;
use App\Models\PerangkatDaerah;
use App\Models\Misi;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            $agendas = Agenda::with(['jabatan', 'pakaian', 'surat'])
                ->join('jabatans', 'agendas.id_jabatan', '=', 'jabatans.id')
                ->orderBy('jabatans.prioritas', 'asc') // semakin kecil = jabatan lebih tinggi
                ->select('agendas.*')
                ->get();
        }

        return view('admin.agenda.index', compact('agendas'));
    }


    // Menampilkan form create umum (tanpa preselected surat)
    public function create(Request $request)
    {
        // Ambil semua data yang dibutuhkan
        $surats = Surat::with('perangkatDaerah', 'jabatan')->get();
        $perangkatDaerah = PerangkatDaerah::all();
        $pakaian = Pakaian::all();
        $misis = Misi::all();

        // ✅ CEK JIKA ADA PARAMETER surat_id
        $selectedSurat = null;
        if ($request->has('surat_id')) {
            $selectedSurat = Surat::find($request->surat_id);
        }

        // Filter jabatan berdasarkan role
        if (Auth::user()->role->role_name === 'User') {
            $jabatans = Jabatan::where('id_perangkat_daerah', Auth::user()->id_perangkat_daerah)->get();
        } else {
            $jabatans = Jabatan::all();
        }

        return view('admin.agenda.create', compact(
            'surats',
            'perangkatDaerah',
            'jabatans',
            'pakaian',
            'misis',
            'selectedSurat' // ✅ KIRIM DATA SURAT YANG DIPILIH
        ));
    }


    // Form create khusus saat dipanggil dari surat tertentu: /agenda/create/{surat}
    // Menggunakan route model binding (Surat $surat)
    public function createBySurat(Surat $surat)
    {
        $user = Auth::user();

        $perangkatDaerah = ($user->role->role_name === 'User')
            ? collect([$user->perangkatDaerah])
            : PerangkatDaerah::orderBy('singkatan')->get();

        $jabatans = ($user->role->role_name === 'User')
            ? Jabatan::where('id_perangkat_daerah', $user->id_perangkat_daerah)->get()
            : Jabatan::orderBy('jabatan')->get();

        $surats = Surat::orderBy('created_at', 'desc')->get();
        $pakaian = Pakaian::orderBy('pakaian')->get();

        $misis = Misi::orderBy('misi')->get();
        $programs = collect();

        $selectedSurat = $surat;

        return view('admin.agenda.create', compact(
            'perangkatDaerah',
            'jabatans',
            'surats',
            'pakaian',
            'misis',
            'programs',
            'selectedSurat'
        ));
    }

    // 🔹 AJAX: Ambil Jabatan berdasarkan Perangkat Daerah
    public function getJabatan($id_perangkat_daerah)
    {
        try {
            // Log untuk debugging
            Log::info('Getting jabatan for perangkat_daerah_id: ' . $id_perangkat_daerah);

            // Query jabatan berdasarkan id_perangkat_daerah
            $jabatans = Jabatan::where('id_perangkat_daerah', $id_perangkat_daerah)
                ->select('id', 'jabatan')
                ->orderBy('jabatan', 'asc')
                ->get();

            // Log hasil query
            Log::info('Jabatan found: ' . $jabatans->count());

            return response()->json($jabatans);

        } catch (\Exception $e) {
            Log::error('Error in getJabatan: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // 🔹 AJAX: Ambil Program berdasarkan Misi
    public function getProgramsByMisi($id_misi)
    {
        try {
            Log::info('Getting programs for id_misi: ' . $id_misi);

            $programs = Program::where('id_misi', $id_misi)
                ->select('id', 'description')
                ->orderBy('description', 'asc')
                ->get();

            Log::info('Programs found: ' . $programs->count());

            return response()->json($programs);

        } catch (\Exception $e) {
            Log::error('Error in getProgramsByMisi: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
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
            'id_misi' => 'nullable|exists:misis,id',
            'id_program' => 'nullable|exists:programs,id',
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
        $agenda = Agenda::with(['surat', 'jabatan', 'pakaian', 'misi', 'program', 'photos'])->findOrFail($id);

        $surats = Surat::all();
        $jabatans = Jabatan::all();
        $pakaian = Pakaian::all();
        $misis = Misi::all();

        // Load programs berdasarkan misi yang sudah dipilih
        $programs = Program::where('id_misi', $agenda->id_misi)->get();

        // Untuk admin, ambil semua perangkat daerah
        if (Auth::user()->role->role_name === 'Admin') {
            $perangkatDaerah = PerangkatDaerah::all();
        }

        return view('admin.agenda.edit', compact('agenda', 'surats', 'jabatans', 'pakaian', 'misis', 'programs'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'id_surat' => 'required|exists:surats,id',
            'agenda' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'tempat' => 'required|string|max:255',
            'id_jabatan' => 'required|exists:jabatans,id',
            'id_pakaian' => 'nullable|exists:pakaians,id',
            'id_misi' => 'required|exists:misis,id',
            'id_program' => 'required|exists:programs,id',
            'resume' => 'nullable|string',
            'fotos.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hapus_foto' => 'nullable|array',
            'hapus_foto.*' => 'exists:agenda_photos,id'
        ]);

        try {
            $agenda = Agenda::findOrFail($id);

            // Update data agenda
            $agenda->update([
                'id_surat' => $validated['id_surat'],
                'agenda' => $validated['agenda'],
                'tanggal' => $validated['tanggal'],
                'waktu' => $validated['waktu'],
                'tempat' => $validated['tempat'],
                'id_jabatan' => $validated['id_jabatan'],
                'id_pakaian' => $validated['id_pakaian'],
                'id_misi' => $validated['id_misi'],
                'id_program' => $validated['id_program'],
                'resume' => $validated['resume'],
            ]);

            // Hapus foto yang dipilih
            if ($request->has('hapus_foto')) {
                foreach ($request->hapus_foto as $photoId) {
                    $photo = AgendaPhoto::find($photoId);
                    if ($photo && $photo->agenda_id == $agenda->id) {
                        // Hapus file dari storage
                        Storage::disk('public')->delete($photo->path);
                        // Hapus record dari database
                        $photo->delete();
                    }
                }
            }

            // Upload foto baru
            if ($request->hasFile('fotos')) {
                foreach ($request->file('fotos') as $foto) {
                    $path = $foto->store('agenda_photos', 'public');

                    AgendaPhoto::create([
                        'agenda_id' => $agenda->id,
                        'path' => $path
                    ]);
                }
            }

            return redirect()->route('agenda.index')
                ->with('success', 'Agenda berhasil diupdate!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal mengupdate agenda: ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->delete();

        return redirect()->route('agenda.index')
            ->with('success', ' Agenda berhasil dihapus.');
    }
}
