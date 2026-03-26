<?php

use App\Jobs\SendStudyEmailJob;
use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

[$script, $to, $subject, $message] = array_pad($argv, 4, null);

if (! $to || ! $subject || ! $message) {
    fwrite(STDERR, "Usage: php scripts/dispatch-study-email.php <to> <subject> <message>\n");
    exit(2);
}

SendStudyEmailJob::dispatch(
    to: $to,
    subject: $subject,
    message: $message,
)->onQueue('emails');

fwrite(STDOUT, "Queued job on queue=emails to={$to}\n");
