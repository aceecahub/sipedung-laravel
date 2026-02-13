<?php

namespace App\Models;

use App\Models\User;
use App\Models\Warga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KepalaKeluarga extends Model
{
    use HasFactory;
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
}
