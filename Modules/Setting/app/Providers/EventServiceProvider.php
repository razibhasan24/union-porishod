<?php

namespace Modules\Setting\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \Modules\Setting\Events\ApplicationStatusChanged::class => [
            \Modules\Setting\Listeners\SendApplicationStatusSms::class,
        ],
    ];
}