<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\KasAgustus;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class KasAgustusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kas = KasAgustus::with('warga')->get();
        return Inertia::render('rt/KasAgustus', [
            'kas' => $kas,
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
            'id_warga' => 'required',
            'jumlah' => 'required|integer',
            'tanggal' => 'required|date',
            'status_perelek' => 'required|in:Ada,Tidak Ada',
            'keterangan' => 'nullable|max:255',
        ]);

        return redirect()->route('kas.index')->with('success', 'Data kas Agustus berhasil ditambahkan.');
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
    public function destroy(string $id)
    {
        //
    }
}
