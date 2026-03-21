<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            static::logActivity($model, 'created');
        });

        static::updated(function ($model) {
            static::logActivity($model, 'updated');
        });

        static::deleted(function ($model) {
            static::logActivity($model, 'deleted');
        });
    }

    protected static function logActivity($model, $action)
    {
        if (Auth::check()) {
            $description = static::getActivityDescription($model, $action);
            
            ActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $action,
                'model_type' => get_class($model),
                'model_id' => $model->getAttribute($model->getKeyName()),
                'description' => $description,
            ]);
        }
    }

    protected static function getActivityDescription($model, $action)
    {
        $name = $model->nama ?? $model->name ?? "Data #{$model->id}";
        $modelName = class_basename($model);
        
        switch ($action) {
            case 'created':
                return "Menambahkan {$modelName} baru: {$name}";
            case 'updated':
                return "Memperbarui data {$modelName}: {$name}";
            case 'deleted':
                return "Menghapus {$modelName}: {$name}";
            default:
                return "Melakukan {$action} pada {$modelName}: {$name}";
        }
    }
}
