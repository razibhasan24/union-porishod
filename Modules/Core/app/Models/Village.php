<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Village extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'union_id', 'ward_id', 'name_bn', 'name_en', 'code',
        'post_office', 'post_code', 'population', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function union()
    {
        return $this->belongsTo(Union::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}