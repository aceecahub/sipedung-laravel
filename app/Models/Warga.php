<?php

namespace App\Models;

use App\Models\User;
use App\Models\KepalaKeluarga;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

}
