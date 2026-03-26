<?php

use App\Jobs\SendStudyEmailJob;
use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

[$script, $queue, $to, $subject, $message] = array_pad($argv, 5, null);

if (! $queue || ! $to || ! $subject || ! $message) {
    fwrite(STDERR, "Usage: php scripts/dispatch-study-email-custom.php <queue> <to> <subject> <message>\n");
    exit(2);
}

SendStudyEmailJob::dispatch(
    to: $to,
    subject: $subject,
    message: $message,
)->onQueue($queue);

echo "Queued job on queue={$queue} to={$to}\n";