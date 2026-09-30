<?php

namespace Modules\Core\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'union_id', 'group', 'key', 'value', 'type',
        'label_bn', 'label_en', 'options', 'sort_order',
    ];

    public function union()
    {
        return $this->belongsTo(Union::class);
    }

    public function getCastedValueAttribute()
    {
        return match($this->type) {
            'boolean' => (bool) $this->value,
            'number' => (int) $this->value,
            'json' => json_decode($this->value, true),
            default => $this->value,
        };
    }
}