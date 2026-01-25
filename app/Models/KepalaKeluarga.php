<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class KepalaKeluarga extends Model
{
    use HasFactory;
    protected $guarded = ['id_kk'];
    protected $table = 'kepala_keluargas';
    protected $primaryKey = 'id_kk';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
