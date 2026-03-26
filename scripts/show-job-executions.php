<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

$rows = App\Models\JobExecution::query()
    ->latest('id')
    ->limit(10)
    ->get(['id', 'job_id', 'status', 'job_name', 'queue', 'duration_ms', 'last_error', 'created_at']);

echo $rows->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;