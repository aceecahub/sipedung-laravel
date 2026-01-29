<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

// Models
use App\Models\KepalaKeluarga;
use App\Models\User;

class KepalaKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kk = KepalaKeluarga::all();
        $user = User::select('id_user', 'email')->get();
        return Inertia::render('rt/KepalaKeluarga', [
            'kk' => $kk,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request): RedirectResponse
    {
        $dataValidate = $request->validate([
            'id_user' => 'required',
            'kk' => 'required|numeric',
            'nik' => 'required|numeric',
            'nama' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'nohp' => 'required|max:20',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha',
            'pekerjaan' => 'required|max:255',
        ]);

        KepalaKeluarga::create($dataValidate);

        //kembalikan ke fungsi index
        return redirect()->route('kepala-keluarga.index')->with('message', 'Data berhasil ditambahkan');
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
        return redirect()->route('kepala-keluarga.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KepalaKeluarga $kepalaKeluarga): RedirectResponse
    {
        $dataValidate = $request->validate([
            'id_user' => 'required',
            'kk' => 'required|numeric',
            'nik' => 'required|numeric',
            'nama' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'nohp' => 'required|max:20',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha',
            'pekerjaan' => 'required|max:255',
        ]);

        $kepalaKeluarga->update($dataValidate);

        return redirect()->route('kepala-keluarga.index')->with('message', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kk = KepalaKeluarga::findOrFail($id);
        $kk->delete();

        // Gunakan back() atau route() untuk memicu refresh data props otomatis
        return redirect()->route('kepala-keluarga.index')->with('message', 'Data berhasil dihapus');
    }
}
