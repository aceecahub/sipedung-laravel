<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warga = Warga::all();
        return Inertia::render('rt/Warga', [
            'warga' => $warga,
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
    public function store(Request $request): RedirectResponse
    {
        $dataValidate = $request->validate([
            'id_user' => 'required',
            'id_kk' => 'required',
            'nik' => 'required|unique:wargas,nik|numeric',
            'nama' => 'required|max:255',
            'tempat_lahir' => 'required|max:255',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'nohp' => 'required|max:20',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'status_perkawinan' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'pekerjaan' => 'nullable|max:255',
            'goldar' => 'nullable|in:A,B,AB,O',
            'status' => 'required|in:Hidup,Meninggal',
        ]);

        Warga::create($dataValidate);

        return redirect()->route(warga.index);
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
        $warga = Warga::findOrFail($id);
        $warga->delete();

        // Gunakan back() atau route() untuk memicu refresh data props otomatis
        return redirect()->back()->with('message', 'Data berhasil dihapus');
    }
}
