<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->get();
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.role.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate(
            [
                'role_name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
            ],
            [
                'role_name.required' => 'The item role is required',
                'description.string' => 'The description must be string'
            ]
        );

        // Save the item to the database
        $role = Role::create($validatedData);

        // Redirect to the perangkat daerah index with success message
        return redirect()->route('role.index')
            ->with('success', ' Role Berhasil Ditambahkan');
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
        $role = Role::findOrFail($id);
        return view('admin.role.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate(
            [
                'role_name' => 'required|string|max:255',
                'description' => 'nullable|string|max:255',
            ],
            [
                'role_name.required' => 'The item role is required',
                'description.string' => 'The description must be string'
            ]
        );

        // Find the item and update it
        $role = Role::findOrFail($id);
        $role->update($validatedData);

        // Redirect to the perangkat daerah index with success message
        return redirect()->route('role.index')
            ->with('success', ' Role Berhasil Diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::findOrFail($id);
        $role->delete();

        return redirect()->route('role.index')
            ->with('success', ' Role Berhasil Dihapus');
    }
}
