<?php

namespace App\Providers;

use App\Listeners\JobExecutionSubscriber;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::subscribe(JobExecutionSubscriber::class);
    }
}

