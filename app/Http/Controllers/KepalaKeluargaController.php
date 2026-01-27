<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\KepalaKeluarga;
use Illuminate\Http\RedirectResponse;

class KepalaKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kk = KepalaKeluarga::all();
        return Inertia::render('rt/KepalaKeluarga', [
            'kk' => $kk,
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
            'kk' => 'required|unique:kepala_keluargas,kk|numeric',
            'nik' => 'required|unique:kepala_keluargas,nik|numeric',
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
        return redirect()->route('kepala-keluarga.index');
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
        $data = $request->validate([
            'kk' => 'required|numeric|unique:kepala_keluargas,kk,' . $kepalaKeluarga->id_kk . ',id_kk',
            'nik' => 'required|numeric|unique:kepala_keluargas,nik,' . $kepalaKeluarga->id_kk . ',id_kk',
            'nama' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'nohp' => 'required|max:20',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha',
            'pekerjaan' => 'required|max:255',
        ]);

        $kepalaKeluarga->update($data);

        return redirect()->route('kepala-keluarga.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kk = KepalaKeluarga::findOrFail($id);
        $kk->delete();

        // Gunakan back() atau route() untuk memicu refresh data props otomatis
        return redirect()->back()->with('message', 'Data berhasil dihapus');
    }
}
