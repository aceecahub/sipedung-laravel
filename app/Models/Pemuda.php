<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pemuda extends Model
{
    use HasFactory;

    protected $guarded = ['id_pemuda'];
    protected $table = 'pemudas';
    protected $primaryKey = 'id_pemuda';

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }
}
