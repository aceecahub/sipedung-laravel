<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
}
