<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Models
use App\Models\User;
use App\Models\Pemuda;
use App\Models\KepalaKeluarga;

class Warga extends Model
{
    use HasFactory;
    protected $guarded = ['id_warga'];
    protected $table = 'wargas';
    protected $primaryKey = 'id_warga';

    // User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Kepala Keluarga
    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'id_kk');
    }

    // Kas Agustus
    public function kasAgustus()
    {
        return $this->hasMany(KasAgustus::class, 'id_warga');
    }

    // pemuda
    public function pemuda()
    {
        return $this->belongsTo(Pemuda::class, 'id_warga');
    }
}
