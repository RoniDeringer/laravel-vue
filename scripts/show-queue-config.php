<?php

use Illuminate\Contracts\Console\Kernel;

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "queue.default=" . config('queue.default') . PHP_EOL;
$default = config('queue.default');
print_r(config("queue.connections.{$default}"));