<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KepalaKeluarga extends Model
{
    use HasFactory;
    protected $guarded = ['id_kk'];
    protected $table = 'kepala_keluargas';
    protected $primaryKey = 'id_kk';
}
