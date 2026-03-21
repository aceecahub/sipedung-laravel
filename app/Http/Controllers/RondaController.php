<?php

namespace App\Http\Controllers;

use App\Models\Ronda;
use App\Models\DendaRonda;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\KepalaKeluarga;

class RondaController extends Controller
{
    /**
     * Display a listing of the resource for RT and KK.
     */
    public function index()
    {
        $user = auth()->user();
        $isKK = $user->role === 'kk';
        $kkData = null;
        if ($isKK) {
            $kkData = KepalaKeluarga::where('id_user', $user->id_user)->first();
        }

        return Inertia::render('rt/Ronda', [
            'isKK' => $isKK,
            'kkData' => $kkData,
            'todayAttendance' => Ronda::with('kepalaKeluarga')->whereDate('tanggal', date('Y-m-d'))->get(),
            'schedule' => $this->getJadwalData(),
            'allHistory' => Ronda::with('kepalaKeluarga')->latest()->take(100)->get(),
        ]);
    }

    private function getJadwalData()
    {
        $groups = [];
        for ($i = 1; $i <= 7; $i++) {
            $groups[$i] = KepalaKeluarga::where('kelompok_ronda', (string)$i)->get();
        }
        return $groups;
    }

    /**
     * Get the schedule and groups for RT/Public.
     */
    public function getJadwal()
    {
        return response()->json($this->getJadwalData());
    }
    
    /**
     * Store a newly created resource in storage (Absen).
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kk' => 'required|exists:kepala_keluargas,id_kk',
            'status' => 'required|in:Hadir,Izin,Sakit,Tanpa Keterangan',
            'keterangan' => 'nullable|string',
        ]);

        $kk = KepalaKeluarga::findOrFail($request->id_kk);
        $todayDayNum = date('N'); // 1 (Mon) to 7 (Sun)

        // Check if it's the right schedule day
        if ($kk->kelompok_ronda != $todayDayNum) {
            return back()->withErrors(['id_kk' => 'Bukan jadwal ronda anda hari ini.']);
        }

        // Check if already absented today
        $exists = Ronda::where('id_kk', $request->id_kk)
            ->whereDate('tanggal', date('Y-m-d'))
            ->exists();

        if ($exists) {
            return back()->withErrors(['id_kk' => 'Anda sudah mengisi absen hari ini.']);
        }

        $ronda = Ronda::create([
            'id_kk' => $request->id_kk,
            'tanggal' => date('Y-m-d'),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        // If 'Izin', create denda automatically
        if ($request->status === 'Izin') {
            DendaRonda::create([
                'id_kk' => $request->id_kk,
                'deskripsi' => 'Denda Izin Ronda tanggal ' . date('d-m-Y'),
                'jumlah' => 20000,
                'status_pembayaran' => 'Belum Bayar',
                'tanggal' => date('Y-m-d'),
            ]);
        }

        return redirect()->route('ronda.index')->with('message', 'Absen berhasil disimpan.');
    }

    /**
     * Get attendance for today for RT.
     */
    public function getTodayAttendance()
    {
        $attendance = Ronda::with('kepalaKeluarga')
            ->whereDate('tanggal', date('Y-m-d'))
            ->get();
        
        return response()->json($attendance);
    }
}
