<?php

namespace Modules\Certificate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Core\Models\Union;

class CertificateType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'union_id', 'name_bn', 'name_en', 'code',
        'description_bn', 'description_en',
        'serial_prefix', 'serial_start', 'current_serial', 'serial_padding',
        'fee', 'renewal_fee', 'duplicate_fee',
        'validity_days', 'renewal_validity_days', 'print_after_days',
        'is_warish', 'requires_heirs', 'requires_property',
        'needs_ward_verification', 'needs_chairman_approval', 'needs_secretary_approval',
        'template', 'template_data',
        'icon', 'color', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_warish' => 'boolean',
        'requires_heirs' => 'boolean',
        'requires_property' => 'boolean',
        'needs_ward_verification' => 'boolean',
        'needs_chairman_approval' => 'boolean',
        'needs_secretary_approval' => 'boolean',
        'is_active' => 'boolean',
        'fee' => 'decimal:2',
        'renewal_fee' => 'decimal:2',
        'duplicate_fee' => 'decimal:2',
        'template_data' => 'array',
    ];

    public function union()
    {
        return $this->belongsTo(Union::class);
    }

    public function applications()
    {
        return $this->hasMany(CertificateApplication::class);
    }

    public function generateNextNumber(): string
    {
        $this->increment('current_serial');
        $this->refresh();

        $year = date('Y');
        $serial = str_pad($this->current_serial, $this->serial_padding, '0', STR_PAD_LEFT);

        return "{$this->serial_prefix}/{$year}/{$serial}";
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name_bn ?? $this->name_en;
    }
}