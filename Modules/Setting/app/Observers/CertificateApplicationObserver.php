<?php

namespace Modules\Setting\Observers;

use Modules\Certificate\Models\CertificateApplication;
use Modules\Setting\Events\ApplicationStatusChanged;

class CertificateApplicationObserver
{
    public function updated(CertificateApplication $application): void
    {
        if ($application->isDirty('status')) {
            $from = $application->getOriginal('status');
            $to = $application->status;

            // Convert enum to string if needed
            if ($from instanceof \UnitEnum) $from = $from->value;
            if ($to instanceof \UnitEnum) $to = $to->value;

            if ($from !== $to) {
                event(new ApplicationStatusChanged(
                    $application->fresh(),
                    (string) $from,
                    (string) $to,
                    $application->chairman_remarks ?? $application->ward_remarks
                ));
            }
        }
    }
}