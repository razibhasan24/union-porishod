<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Modules\Core\Models\Union;
use Modules\Core\Models\Ward;
use Modules\Core\Models\Village;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, SoftDeletes;

    protected $fillable = [
        'union_id', 'ward_id', 'village_id',
        'name', 'name_bn', 'email', 'phone', 'password',
        'nid', 'photo', 'user_type',
        'phone_verified', 'otp', 'otp_expires_at',
        'is_active', 'last_login_at', 'last_login_ip', 'locale',
    ];

    protected $hidden = ['password', 'remember_token', 'otp'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified' => 'boolean',
        'is_active' => 'boolean',
        'otp_expires_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
    ];

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

    public function isSuperAdmin(): bool
    {
        return $this->user_type === 'super_admin';
    }

    public function isChairman(): bool
    {
        return $this->user_type === 'chairman';
    }

    public function isSecretary(): bool
    {
        return $this->user_type === 'secretary';
    }

    public function isWardMember(): bool
    {
        return $this->user_type === 'ward_member';
    }

    public function isApplicant(): bool
    {
        return $this->user_type === 'applicant';
    }

    public function isAdminPanelUser(): bool
    {
        return in_array($this->user_type, [
            'super_admin', 'chairman', 'secretary',
            'ward_member', 'female_member', 'accountant',
            'certificate_officer', 'office_staff',
        ]);
    }

    public function applications()
    {
        return $this->hasMany(
            \Modules\Certificate\Models\CertificateApplication::class,
            'applicant_id'
        );
    }

    public function wardApplications()
    {
        return $this->hasMany(
            \Modules\Certificate\Models\CertificateApplication::class,
            'ward_member_id'
        );
    }

    public function chairmanApplications()
    {
        return $this->hasMany(
            \Modules\Certificate\Models\CertificateApplication::class,
            'chairman_id'
        );
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name_bn ?? $this->name;
    }

    public function getPhotoUrlAttribute(): string
    {
        return $this->photo
            ? asset('storage/' . $this->photo)
            : asset('images/default-avatar.png');
    }
}