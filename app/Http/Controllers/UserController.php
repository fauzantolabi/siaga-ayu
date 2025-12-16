<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PerangkatDaerah;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        $perangkatDaerah = PerangkatDaerah::all();
        return view('admin.user.index', compact('users', 'perangkatDaerah'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $perangkatDaerah = PerangkatDaerah::all();
        $roles = Role::all();
        return view('admin.user.create', compact('perangkatDaerah', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|integer',
            'id_perangkat_daerah' => 'required|integer',
            'phone' => 'nullable|string|max:15',
            // 'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = new User();
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role_id = $request->role_id;
        $user->id_perangkat_daerah = $request->id_perangkat_daerah;
        $user->phone = $request->phone;

        // kalau ada upload foto
        if ($request->hasFile('foto')) {
            $path = $request->file('foto')->store('users', 'public');
            $user->foto = $path;
        }

        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan.');
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
        $user = User::findOrFail($id);
        $perangkatDaerah = PerangkatDaerah::all();
        $roles = Role::all();
        return view('admin.user.edit', compact('user', 'perangkatDaerah', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fullname' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|string',
            'id_perangkat_daerah' => 'required|string',
            'phone' => 'nullable|string|max:15',
        ], [
            'role_id.required' => 'The role field is required.',
            'id_perangkat_daerah.required' => 'The perangkat daerah field is required.',
            'phone.max' => 'The phone number may not be greater than 15 characters.',
            'phone.string' => 'The phone number must be a string.',
            'phone.nullable' => 'The phone number field can be left empty.',
            'foto.image' => 'The foto must be an image.',
            'foto.mimes' => 'The foto must be a file of type: jpeg, png, jpg, gif, svg.',
            'foto.max' => 'The foto may not be greater than 2MB.',

        ]);
        $user = User::findOrFail($id);
        $user->fullname = $request->fullname;
        $user->username = $request->username;
        $user->email = $request->email;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->role_id = $request->role_id;
        $user->id_perangkat_daerah = $request->id_perangkat_daerah;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            // Cek apakah user yang akan dihapus adalah user yang sedang login
            if ($user->id === auth()->id()) {
                return redirect()->route('user.index')
                    ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
            }

            $user->delete();

            return redirect()->route('user.index')
                ->with('success', 'User berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('user.index')
                ->with('error', 'Gagal menghapus user: ' . $e->getMessage());
        }
    }

}
