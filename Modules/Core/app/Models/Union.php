<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Union extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name_bn', 'name_en', 'code',
        'upazila_bn', 'upazila_en', 'district_bn', 'district_en',
        'division_bn', 'division_en', 'post_office', 'post_code',
        'phone', 'mobile', 'email', 'website',
        'logo', 'favicon', 'banner', 'letterhead',
        'chairman_name_bn', 'chairman_name_en', 'chairman_phone',
        'chairman_email', 'chairman_photo', 'chairman_signature',
        'chairman_from_date', 'chairman_to_date',
        'secretary_name_bn', 'secretary_name_en', 'secretary_phone',
        'secretary_photo',
        'total_wards', 'total_villages', 'total_population',
        'total_voters', 'total_area', 'established_date', 'is_active',
    ];

    protected $casts = [
        'chairman_from_date' => 'date',
        'chairman_to_date' => 'date',
        'established_date' => 'date',
        'is_active' => 'boolean',
        'total_area' => 'decimal:2',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return $this->name_bn ?? $this->name_en ?? '';
    }

    public function wards()
    {
        return $this->hasMany(Ward::class)->orderBy('ward_no');
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }

    public function settings()
    {
        return $this->hasMany(Setting::class);
    }

    public function certificateTypes()
    {
        return $this->hasMany(\Modules\Certificate\Models\CertificateType::class);
    }

    public function currentChairman()
    {
        return $this->users()->where('user_type', 'chairman')->first();
    }
}