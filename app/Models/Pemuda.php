<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemuda extends Model
{
    use HasFactory;

    protected $guarded = ['id_pemudas'];
    protected $table = 'pemudas';
    protected $primaryKey = 'id_pemudas';

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }
}
