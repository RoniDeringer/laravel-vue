<?php

namespace App\Jobs;

use App\Mail\StudyEmail;
use App\Models\JobExecution;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendStudyEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;

    public int $timeout = 30;

    public function __construct(
        public string $to,
        public string $subject,
        public string $message,
    ) {}

    public function handle(): void
    {
        $jobId = $this->job?->getJobId();

        $mailable = new StudyEmail(
            subject: $this->subject,
            message: $this->message,
        );

        try {
            $envelope = $mailable->envelope();
            JobExecution::appendLogByJobId($jobId, 'Envelope built', [
                'to' => $this->to,
                'subject' => $envelope->subject,
            ]);

            Mail::to($this->to)->send($mailable);

            JobExecution::appendLogByJobId($jobId, 'Mail sent (mailer dispatch finished)', [
                'to' => $this->to,
            ]);
        } catch (Throwable $e) {
            JobExecution::appendLogByJobId($jobId, 'Mail send failed', [
                'exception' => get_class($e),
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}