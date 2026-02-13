<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

// Models
use App\Models\Warga;
use App\Models\Pemuda;

class PemudaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pemuda = Pemuda::with('warga')->get();
        $warga = Warga::select('id_warga', 'nama')
        ->where('status', 'Hidup')
        ->where('status_perkawinan', 'Belum Menikah')
        ->whereDate('tanggal_lahir', '>=', Carbon::now()->subYears(16))
        ->get();
        return Inertia::render('rt/Dashboard', [
            'pemuda' => $pemuda,
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pemuda $pemuda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemuda $pemuda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemuda $pemuda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemuda $pemuda)
    {
        //
    }
}
