<?php

namespace App\Jobs;

use App\Mail\StudyEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

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
        Mail::to($this->to)->send(new StudyEmail(
            subject: $this->subject,
            message: $this->message,
        ));
    }
}

