<?php

namespace Modules\Certificate\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class ApplicationLog extends Model
{
    protected $fillable = [
        'application_id', 'user_id', 'action',
        'from_status', 'to_status', 'remarks', 'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    public function application()
    {
        return $this->belongsTo(CertificateApplication::class, 'application_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}