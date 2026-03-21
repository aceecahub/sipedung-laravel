<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class DendaRonda extends Model
{
    use LogsActivity;
    protected $table = 'denda_rondas';
    protected $primaryKey = 'id_denda';

    protected static function getActivityDescription($model, $action)
    {
        $kkName = $model->kepalaKeluarga->nama ?? 'Warga';
        switch ($action) {
            case 'created':
                return "Menerbitkan denda ronda untuk keluarga {$kkName}";
            case 'updated':
                return "Mengubah status denda ronda keluarga {$kkName} menjadi {$model->status_pembayaran}";
            case 'deleted':
                return "Menghapus data denda ronda keluarga {$kkName}";
            default:
                return "Aktivitas Denda: keluarga {$kkName}";
        }
    }

    protected $fillable = [
        'id_kk',
        'deskripsi',
        'jumlah',
        'status_pembayaran',
        'tanggal',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'id_kk');
    }
}
