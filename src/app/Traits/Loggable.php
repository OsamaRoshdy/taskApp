<?php

namespace App\Traits;

use App\Models\Log;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\DB;

trait Loggable
{
    public static function logToDb($model, $logType) :void
    {
        if (!auth()->check()) return;
        DB::table('logs')->insert(self::data($model, $logType));
    }

    public static function data($model, $logType) :array
    {

        $originalData = $logType === 'create' ? json_encode($model) : json_encode($model->getRawOriginal());

        return [
            'user_id'    => auth()->user()->id,
            'log_date'   => date('Y-m-d H:i:s'),
            'subject_type' => get_class(),
            'subject_id' => $model->id,
            'ip_address' => request()->ip(),
            'log_type'   => $logType,
            'data'       => $originalData
        ];
    }

    public static function bootLoggable() :void
    {
        self::updated(function ($model) {
            self::logToDb($model, 'edit');
        });

        self::deleted(function ($model) {
            self::logToDb($model, 'delete');
        });

        self::created(function ($model) {
            self::logToDb($model, 'create');
        });
    }

    public function activities() :MorphMany
    {
        return $this->morphMany(Log::class, 'subject');
    }

}
