<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DendaRonda extends Model
{
    protected $table = 'denda_rondas';
    protected $primaryKey = 'id_denda';

    protected $fillable = [
        'id_kk',
        'deskripsi',
        'jumlah',
        'status_pembayaran',
        'tanggal',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'id_kk');
    }
}
