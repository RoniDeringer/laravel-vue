<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobExecution extends Model
{
    protected $fillable = [
        'job_id',
        'job_name',
        'connection',
        'queue',
        'status',
        'attempts',
        'started_at',
        'finished_at',
        'duration_ms',
        'last_error',
        'exception_class',
        'exception_trace',
        'log',
        'payload',
        'meta',
    ];

    protected $casts = [
        'payload' => 'array',
        'meta' => 'array',
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
    ];

    public static function appendLogByJobId(?string $jobId, string $message, array $context = []): void
    {
        if (! $jobId) return;

        $execution = static::query()->where('job_id', $jobId)->latest('id')->first();
        if (! $execution) return;

        $line = '['.now()->toIso8601String().'] '.$message;
        if ($context !== []) {
            $line .= ' '.json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $execution->log = trim(($execution->log ? $execution->log."\n" : '').$line);
        $execution->save();
    }
}

