<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Traits\LogsActivity;

class Pemuda extends Model
{
    use HasFactory, LogsActivity;

    protected static function getActivityDescription($model, $action)
    {
        $name = $model->warga->nama ?? 'Seseorang';
        switch ($action) {
            case 'created':
                return "Mendaftarkan {$name} sebagai anggota Pemuda";
            case 'updated':
                return "Memperbarui data Pemuda: {$name}";
            case 'deleted':
                return "Menghapus {$name} dari status Pemuda";
            default:
                return "Aktivitas Pemuda: {$name}";
        }
    }

    protected $guarded = ['id_pemuda'];
    protected $table = 'pemudas';
    protected $primaryKey = 'id_pemuda';

    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }
}
