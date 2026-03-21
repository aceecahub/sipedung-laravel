<?php

namespace App\Models;

use App\Models\User;
use App\Models\Warga;
use App\Models\Ronda;
use App\Models\DendaRonda;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\LogsActivity;

class KepalaKeluarga extends Model
{
    use HasFactory, LogsActivity;
    protected $guarded = ['id_kk'];
    protected $table = 'kepala_keluargas';
    protected $primaryKey = 'id_kk';

    // User
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    // Warga
    public function warga()
    {
        return $this->hasMany(Warga::class, 'id_kk');
    }

    // Ronda
    public function rondas()
    {
        return $this->hasMany(Ronda::class, 'id_kk');
    }

    // Denda
    public function dendaRondas()
    {
        return $this->hasMany(DendaRonda::class, 'id_kk');
    }
}
