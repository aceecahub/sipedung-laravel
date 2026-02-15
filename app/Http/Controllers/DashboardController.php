<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Inertia\Inertia;
use App\Models\Warga;
use Illuminate\Http\Request;
use App\Models\KepalaKeluarga;
use App\Models\Pemuda;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // data total master
        $kk = KepalaKeluarga::count();
        $warga = Warga::count();

        // Hitung pemuda dan lansia
        $age17 = Carbon::now()->subYears(17);
        $age60 = Carbon::now()->subYears(60);

        // query table - untuk count statistik
        $pemudaCount = Warga::where('tanggal_lahir', '<=', $age17)
            ->where('tanggal_lahir', '>', $age60)
            ->count();
        $lansia = Warga::where('tanggal_lahir', '<', $age60)->count();

        // Ambil data pemuda lengkap dengan kondisi dari PemudaController
        $pemuda = Pemuda::with('warga')->get();

        // chart gender warga
        $gender = Warga::select('jenis_kelamin', DB::raw('count(*) as count'))
            ->groupBy('jenis_kelamin')
            ->get();

        // chart status warga
        $status = Warga::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get();

        // return inertia
        return Inertia::render('rt/Dashboard', [
            'kk' => $kk,
            'warga' => $warga,
            'pemudaCount' => $pemudaCount, // untuk statistik card
            'pemuda' => $pemuda, // untuk tabel pemuda
            'lansia' => $lansia,
            'gender' => $gender,
            'status' => $status
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
