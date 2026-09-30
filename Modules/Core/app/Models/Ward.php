<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'union_id', 'ward_no', 'name_bn', 'name_en',
        'member_name_bn', 'member_name_en', 'member_phone',
        'member_photo', 'member_signature',
        'female_member_name_bn', 'female_member_phone',
        'total_villages', 'total_population', 'total_voters', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function union()
    {
        return $this->belongsTo(Union::class);
    }

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function wardMember()
    {
        return $this->hasOne(\App\Models\User::class)
                    ->where('user_type', 'ward_member');
    }

    public function getDisplayNameAttribute(): string
    {
        return $this->name_bn ?? "ওয়ার্ড নং {$this->ward_no}";
    }
}