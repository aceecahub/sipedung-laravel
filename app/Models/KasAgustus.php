<?php

namespace App\Models;

use App\Models\KepalaKeluarga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KasAgustus extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'kas_agustus';

    // Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }

    // KK
    public function kk()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'id_kk');
    }
}
