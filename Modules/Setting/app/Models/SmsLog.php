<?php

namespace Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SmsLog extends Model
{
    protected $fillable = [
        'mobile', 'message', 'template_key', 'gateway',
        'status', 'reference_id', 'response', 'error_message',
        'user_id', 'related_type', 'related_id', 'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function related()
    {
        return $this->morphTo();
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'sent' => 'success',
            'pending' => 'warning',
            'failed' => 'danger',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'sent' => 'পাঠানো হয়েছে',
            'pending' => 'অপেক্ষমাণ',
            'failed' => 'ব্যর্থ',
            default => $this->status,
        };
    }
}