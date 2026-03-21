<?php

namespace App\Models;

use App\Models\KepalaKeluarga;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Traits\LogsActivity;

class KasAgustus extends Model
{
    use HasFactory, LogsActivity;

    protected $guarded = ['id'];
    protected $table = 'kas_agustus';

    protected static function getActivityDescription($model, $action)
    {
        $kkName = $model->kk->nama ?? 'Warga';
        switch ($action) {
            case 'created':
                return "Mencatat pembayaran Kas Agustus dari keluarga {$kkName}";
            case 'updated':
                return "Memperbarui catatan pembayaran Kas Agustus keluarga {$kkName}";
            case 'deleted':
                return "Menghapus catatan pembayaran Kas Agustus keluarga {$kkName}";
            default:
                return "Aktivitas Kas Agustus: keluarga {$kkName}";
        }
    }

    // Warga
    public function warga()
    {
        return $this->belongsTo(Warga::class, 'id_warga');
    }

    // KK
    public function kk()
    {
        return $this->belongsTo(KepalaKeluarga::class, 'id_kk');
    }
}
