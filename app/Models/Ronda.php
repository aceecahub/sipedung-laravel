<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class Ronda extends Model
{
    use LogsActivity;
    protected $table = 'rondas';
    protected $primaryKey = 'id_ronda';

    protected static function getActivityDescription($model, $action)
    {
        $kkName = $model->kepalaKeluarga->nama ?? 'Warga';
        switch ($action) {
            case 'created':
                return "Melakukan absen ronda untuk keluarga {$kkName} (Status: {$model->status})";
            case 'updated':
                return "Memperbarui absen ronda keluarga {$kkName}";
            case 'deleted':
                return "Menghapus data absen ronda keluarga {$kkName}";
            default:
                return "Aktivitas Ronda: keluarga {$kkName}";
        }
    }

    protected $fillable = [
        'id_kk',
        'tanggal',
        'status',
        'keterangan',
    ];

    public function kepalaKeluarga()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'id_kk');
    }
}
