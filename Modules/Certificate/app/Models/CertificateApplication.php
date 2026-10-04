<?php

namespace Modules\Certificate\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Modules\Core\Models\Union;
use Modules\Core\Models\Ward;
use Modules\Core\Models\Village;
use Modules\Certificate\Enums\ApplicationStatus;

class CertificateApplication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'tracking_no', 'union_id', 'ward_id', 'village_id',
        'applicant_id', 'certificate_type_id',
        'form_data',
        'applicant_name_bn', 'applicant_name_en', 'applicant_father_name',
        'applicant_mother_name', 'applicant_nid', 'applicant_phone', 'applicant_address',
        'documents',
        'deceased_info', 'heirs', 'property_info',
        'payment_method', 'payment_status', 'amount', 'paid_amount',
        'payment_ref', 'paid_at', 'collected_by',
        'status',
        'ward_member_id', 'ward_action_at', 'ward_remarks',
        'chairman_id', 'chairman_action_at', 'chairman_remarks',
        'print_available_at', 'print_allowed', 'print_allowed_by', 'print_allowed_at',
        'delivered_at', 'delivered_to', 'delivery_signature',
        'parent_application_id', 'renewal_count', 'is_renewal',
    ];

    protected $casts = [
        'form_data' => 'array',
        'documents' => 'array',
        'deceased_info' => 'array',
        'heirs' => 'array',
        'property_info' => 'array',
        'paid_at' => 'datetime',
        'ward_action_at' => 'datetime',
        'chairman_action_at' => 'datetime',
        'print_available_at' => 'datetime',
        'print_allowed' => 'boolean',
        'print_allowed_at' => 'datetime',
        'delivered_at' => 'datetime',
        'is_renewal' => 'boolean',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'status' => ApplicationStatus::class,
    ];

    // ================== RELATIONS ==================

    public function union()
    {
        return $this->belongsTo(Union::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }

    public function village()
    {
        return $this->belongsTo(Village::class);
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function certificateType()
    {
        return $this->belongsTo(CertificateType::class);
    }

    public function wardMember()
    {
        return $this->belongsTo(User::class, 'ward_member_id');
    }

    public function chairman()
    {
        return $this->belongsTo(User::class, 'chairman_id');
    }

    public function collectedBy()
    {
        return $this->belongsTo(User::class, 'collected_by');
    }

    public function printAllowedBy()
    {
        return $this->belongsTo(User::class, 'print_allowed_by');
    }

    public function issuedCertificate()
    {
        return $this->hasOne(IssuedCertificate::class, 'application_id');
    }

    public function logs()
    {
        return $this->hasMany(ApplicationLog::class, 'application_id')->latest();
    }

    public function parentApplication()
    {
        return $this->belongsTo(CertificateApplication::class, 'parent_application_id');
    }

    public function renewals()
    {
        return $this->hasMany(CertificateApplication::class, 'parent_application_id');
    }

    // ================== HELPERS ==================

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function canBePrinted(): bool
    {
        if ($this->status !== ApplicationStatus::CHAIRMAN_APPROVED
            && $this->status !== ApplicationStatus::READY_FOR_PRINT) {
            return false;
        }

        if ($this->print_allowed) {
            return true;
        }

        if ($this->print_available_at && now()->greaterThanOrEqualTo($this->print_available_at)) {
            return true;
        }

        return false;
    }

    public function addLog(string $action, ?string $remarks = null): void
    {
        ApplicationLog::create([
            'application_id' => $this->id,
            'user_id' => auth()->id(),
            'action' => $action,
            'from_status' => $this->getOriginal('status'),
            'to_status' => $this->status?->value,
            'remarks' => $remarks,
        ]);
    }

    public function scopeForWard($query, $wardId)
    {
        return $query->where('ward_id', $wardId);
    }

    public function scopePendingForWard($query, $wardId)
    {
        return $query->where('ward_id', $wardId)
                     ->where('status', ApplicationStatus::SENT_TO_WARD);
    }

    public function scopePendingForChairman($query)
    {
        return $query->where('status', ApplicationStatus::SENT_TO_CHAIRMAN);
    }
}
