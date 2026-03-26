<?php

namespace App\Listeners;

use App\Models\JobExecution;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Throwable;

class JobExecutionSubscriber
{
    private function appendLine(JobExecution $execution, string $line): void
    {
        $current = (string) ($execution->log ?? '');
        $lastLine = trim((string) strrchr("\n" . $current, "\n"));

        if ($lastLine === $line) return;

        $execution->log = trim(($current ? $current . "\n" : '') . $line);
    }

    public function handleJobProcessing(JobProcessing $event): void
    {
        $job = $event->job;
        $jobId = (string) $job->getJobId();

        $payload = method_exists($job, 'payload') ? $job->payload() : null;
        $jobName = method_exists($job, 'resolveName') ? $job->resolveName() : null;

        $attempts = null;
        try {
            $attempts = method_exists($job, 'attempts') ? (int) $job->attempts() : null;
        } catch (Throwable) {
            $attempts = null;
        }

        $execution = JobExecution::query()
            ->where('job_id', $jobId)
            ->latest('id')
            ->first();

        if (! $execution || $execution->finished_at) {
            $execution = new JobExecution([
                'job_id' => $jobId,
            ]);
        }

        $execution->job_name = $jobName;
        $execution->connection = method_exists($job, 'getConnectionName') ? $job->getConnectionName() : null;
        $execution->queue = method_exists($job, 'getQueue') ? $job->getQueue() : null;
        $execution->status = 'processing';
        $execution->attempts = $attempts;
        $execution->started_at = $execution->started_at ?? now();
        $execution->payload = $payload;
        $execution->meta = array_merge($execution->meta ?? [], [
            'pid' => function_exists('getmypid') ? getmypid() : null,
            'php' => PHP_VERSION,
        ]);

        $this->appendLine($execution, '[' . now()->toIso8601String() . '] JobProcessing');
        $execution->save();
    }

    public function handleJobProcessed(JobProcessed $event): void
    {
        $job = $event->job;
        $jobId = (string) $job->getJobId();

        $execution = JobExecution::query()
            ->where('job_id', $jobId)
            ->latest('id')
            ->first();

        if (! $execution) return;
        if ($execution->status === 'processed') return;

        $execution->status = 'processed';
        $execution->finished_at = now();

        if ($execution->started_at) {
            $execution->duration_ms = (int) $execution->started_at->diffInMilliseconds($execution->finished_at);
        }

        $this->appendLine($execution, '[' . now()->toIso8601String() . '] JobProcessed');
        $execution->save();
    }

    public function handleJobFailed(JobFailed $event): void
    {
        $job = $event->job;
        $jobId = (string) $job->getJobId();

        $execution = JobExecution::query()
            ->where('job_id', $jobId)
            ->latest('id')
            ->first();

        if (! $execution) {
            $execution = new JobExecution([
                'job_id' => $jobId,
            ]);
        }

        if ($execution->status === 'failed') return;

        $execution->status = 'failed';
        $execution->finished_at = now();
        $execution->started_at = $execution->started_at ?? now();
        $execution->job_name = $execution->job_name ?? (method_exists($job, 'resolveName') ? $job->resolveName() : null);
        $execution->connection = $execution->connection ?? (method_exists($job, 'getConnectionName') ? $job->getConnectionName() : null);
        $execution->queue = $execution->queue ?? (method_exists($job, 'getQueue') ? $job->getQueue() : null);
        $execution->payload = $execution->payload ?? (method_exists($job, 'payload') ? $job->payload() : null);

        if ($execution->started_at) {
            $execution->duration_ms = (int) $execution->started_at->diffInMilliseconds($execution->finished_at);
        }

        $execution->last_error = $event->exception?->getMessage();
        $execution->exception_class = $event->exception ? get_class($event->exception) : null;
        $execution->exception_trace = $event->exception ? $event->exception->getTraceAsString() : null;

        $this->appendLine($execution, '[' . now()->toIso8601String() . '] JobFailed ' . json_encode([
            'exception' => $execution->exception_class,
            'message' => $execution->last_error,
        ], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

        $execution->save();
    }

    public function subscribe($events): void
    {
        $events->listen(JobProcessing::class, [self::class, 'handleJobProcessing']);
        $events->listen(JobProcessed::class, [self::class, 'handleJobProcessed']);
        $events->listen(JobFailed::class, [self::class, 'handleJobFailed']);
    }
}