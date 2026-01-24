<?php

namespace App\Http\Controllers;

use App\Models\KepalaKeluarga;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KepalaKeluargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $agamaOptions = KepalaKeluarga::where('agama')->get();
        $kk = KepalaKeluarga::all();
        return Inertia::render('rt/KepalaKeluarga', [
            'kk' => $kk,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataValidated = $request->validate([
            'kk' => 'required|unique:kepala_keluargas,kk|numeric',
            'nik' => 'required|unique:kepala_keluargas,nik|numeric',
            'nama' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'nohp' => 'required|max:20',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha',
            'pekerjaan' => 'required|max:255',
        ]);

        $kk = KepalaKeluarga::create($dataValidated);

        return response()->json([
            'message' => 'Kepala keluarga berhasil ditambahkan',
            'data' => $kk,
        ], 201);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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

