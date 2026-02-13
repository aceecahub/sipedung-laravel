<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\KasAgustus;
use App\Models\KepalaKeluarga;
use App\Models\Warga;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class KasAgustusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kas = KasAgustus::with('warga', 'kk')->get();
        $data_kk = KepalaKeluarga::select('id_kk', 'nama', 'kk')->get();
        $data_warga = Warga::select('id_warga', 'nama', 'id_kk')->get();
        
        return Inertia::render('rt/KasAgustus', [
            'kas' => $kas,
            'data_kk' => $data_kk,
            'data_warga' => $data_warga,
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
        $dataValidate = $request->validate([
            'id_kk' => 'required',
            'id_warga' => 'required',
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date',
            'status_perelek' => 'required|in:Ada,Tidak Ada',
            'keterangan' => 'nullable|max:255',
        ]);

        $kas = KasAgustus::create($dataValidate);
        return redirect()->route('kas-agustus.index')->with('success', 'Data kas Agustus berhasil ditambahkan.');
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
        $dataValidate = $request->validate([
            'id_kk' => 'required',
            'id_warga' => 'required',
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date',
            'status_perelek' => 'required|in:Ada,Tidak Ada',
            'keterangan' => 'nullable|max:255',
        ]);

        $kas = KasAgustus::findOrFail($id);
        $kas->update($dataValidate);
        
        return redirect()->back()->with('success', 'Data kas Agustus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kas = KasAgustus::findOrFail($id);
        $kas->delete();
        
        return redirect()->back()->with('success', 'Data kas Agustus berhasil dihapus.');
    }
}
