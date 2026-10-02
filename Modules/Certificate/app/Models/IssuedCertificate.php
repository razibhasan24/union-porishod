<?php

namespace Modules\Certificate\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class IssuedCertificate extends Model
{
    protected $fillable = [
        'application_id', 'certificate_no',
        'issue_date', 'expiry_date',
        'pdf_path', 'qr_code', 'verification_code',
        'issued_by', 'issued_by_name', 'issued_by_designation', 'issued_by_signature',
        'print_count', 'first_printed_at', 'last_printed_at',
        'is_valid', 'is_cancelled', 'cancelled_reason', 'cancelled_at',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date',
        'first_printed_at' => 'datetime',
        'last_printed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'is_valid' => 'boolean',
        'is_cancelled' => 'boolean',
    ];

    public function application()
    {
        return $this->belongsTo(CertificateApplication::class, 'application_id');
    }

    public function issuedBy()
    {
        return $this->belongsTo(User::class, 'issued_by');
    }

    public function printLogs()
    {
        return $this->hasMany(PrintLog::class, 'certificate_id');
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function incrementPrintCount(string $type = 'first', ?string $reason = null): void
    {
        $this->increment('print_count');

        if ($this->print_count === 1) {
            $this->update(['first_printed_at' => now()]);
        }
        $this->update(['last_printed_at' => now()]);

        PrintLog::create([
            'certificate_id' => $this->id,
            'printed_by' => auth()->id(),
            'print_type' => $type,
            'reason' => $reason,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}