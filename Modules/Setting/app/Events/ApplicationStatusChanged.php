<?php

namespace Modules\Setting\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ApplicationStatusChanged
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public $application,
        public string $fromStatus,
        public string $toStatus,
        public ?string $remarks = null
    ) {}
}