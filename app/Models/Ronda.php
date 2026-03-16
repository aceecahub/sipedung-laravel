<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ronda extends Model
{
    protected $table = 'rondas';
    protected $primaryKey = 'id_ronda';

    protected $fillable = [
        'id_kk',
        'tanggal',
        'status',
        'keterangan',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'id_kk');
    }
}
