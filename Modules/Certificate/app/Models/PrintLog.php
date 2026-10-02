<?php

namespace Modules\Certificate\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PrintLog extends Model
{
    protected $fillable = [
        'certificate_id', 'printed_by', 'print_type',
        'reason', 'ip_address', 'user_agent',
    ];

    public function certificate()
    {
        return $this->belongsTo(IssuedCertificate::class, 'certificate_id');
    }

    public function printedBy()
    {
        return $this->belongsTo(User::class, 'printed_by');
    }
}