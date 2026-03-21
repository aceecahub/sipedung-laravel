<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\DendaRonda;
use App\Models\KepalaKeluarga;
use App\Models\Ronda;
use Inertia\Inertia;
use Carbon\Carbon;

class DendaRondaController extends Controller
{
    public function index()
    {
        $dendas = DendaRonda::with('kepalaKeluarga')->latest()->get();
        
        $totalBelumBayar = DendaRonda::where('status_pembayaran', 'Belum Bayar')->sum('jumlah');
        $totalLunas = DendaRonda::where('status_pembayaran', 'Lunas')->sum('jumlah');

        return Inertia::render('rt/DendaRonda', [
            'dendas' => $dendas,
            'summary' => [
                'total_belum_bayar' => $totalBelumBayar,
                'total_lunas' => $totalLunas,
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $denda = DendaRonda::findOrFail($id);
        $denda->update([
            'status_pembayaran' => $request->status_pembayaran
        ]);

        return back()->with('message', 'Status pembayaran diperbarui.');
    }

    /**
     * Logic to generate fines for those who missed yesterday's schedule
     */
    public function generateAutoFines()
    {
        // For demonstration, let's check for yesterday (if today is Monday, check Sunday=7)
        $yesterday = Carbon::yesterday();
        $dayNum = $yesterday->dayOfWeekIso; // 1-7

        // Get all KK who should have ronda yesterday
        $scheduledKKs = KepalaKeluarga::where('kelompok_ronda', (string)$dayNum)->get();

        foreach ($scheduledKKs as $kk) {
            // Check if they have an entry in Ronda table for yesterday
            $attended = Ronda::where('id_kk', $kk->id_kk)
                ->whereDate('tanggal', $yesterday->toDateString())
                ->exists();

            if (!$attended) {
                // If already has fine for that day, don't duplicate
                $exists = DendaRonda::where('id_kk', $kk->id_kk)
                    ->whereDate('tanggal', $yesterday->toDateString())
                    ->where('deskripsi', 'like', 'Denda Tidak Absen%')
                    ->exists();

                if (!$exists) {
                    DendaRonda::create([
                        'id_kk' => $kk->id_kk,
                        'deskripsi' => 'Denda Tidak Absen Ronda tanggal ' . $yesterday->format('d-m-Y'),
                        'jumlah' => 20000,
                        'status_pembayaran' => 'Belum Bayar',
                        'tanggal' => $yesterday->toDateString(),
                    ]);
                }
            }
        }

        return back()->with('message', 'Denda otomatis untuk kemarin berhasil diperiksa dan dibuat.');
    }
}
