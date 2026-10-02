<?php

namespace Modules\Payment\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Modules\Certificate\Models\CertificateApplication;

class Payment extends Model
{
    protected $fillable = [
        'application_id', 'payer_id', 'amount',
        'method', 'gateway',
        'transaction_id', 'reference_no', 'payer_mobile',
        'status', 'initiated_at', 'paid_at',
        'collected_by', 'receipt_no',
        'gateway_response', 'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'initiated_at' => 'datetime',
        'paid_at' => 'datetime',
        'gateway_response' => 'array',
    ];

    // ================== RELATIONS ==================

    public function application()
    {
        return $this->belongsTo(CertificateApplication::class, 'application_id');
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    public function collectedBy()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }

    // ================== HELPERS ==================

    public function isSuccessful(): bool
    {
        return $this->status === 'success';
    }

    public function getMethodLabelAttribute(): string
    {
        return match($this->method) {
            'online' => 'অনলাইন',
            'cash' => 'নগদ',
            default => $this->method,
        };
    }

    public function getGatewayLabelAttribute(): string
    {
        return match($this->gateway) {
            'bkash' => 'বিকাশ',
            'nagad' => 'নগদ',
            'rocket' => 'রকেট',
            'cash' => 'নগদ',
            default => $this->gateway ?? '-',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'অপেক্ষমাণ',
            'success' => 'সফল',
            'failed' => 'ব্যর্থ',
            'cancelled' => 'বাতিল',
            default => $this->status,
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'success' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
            default => 'secondary',
        };
    }

    // Generate receipt number
    public static function generateReceiptNo(): string
    {
        $date = date('Ymd');
        $random = strtoupper(substr(md5(uniqid('', true)), 0, 4));
        return "RCP-{$date}-{$random}";
    }

    // Generate transaction id
    public static function generateTransactionId(string $gateway = 'TXN'): string
    {
        return strtoupper($gateway) . '-' . date('YmdHis') . '-' . rand(1000, 9999);
    }
}