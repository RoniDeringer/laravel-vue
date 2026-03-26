<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

[$script, $id] = array_pad($argv, 2, null);

if (! $id) {
    fwrite(STDERR, "Usage: php scripts/show-job-execution.php <id>\n");
    exit(2);
}

$row = App\Models\JobExecution::query()->find($id);

if (! $row) {
    fwrite(STDERR, "Not found\n");
    exit(1);
}

echo $row->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . PHP_EOL;