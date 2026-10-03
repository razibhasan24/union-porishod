<?php

namespace Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    protected $fillable = [
        'key', 'name_bn', 'name_en',
        'body_bn', 'body_en', 'variables', 'is_active',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    public static function findByKey(string $key): ?self
    {
        return static::where('key', $key)->where('is_active', true)->first();
    }

    public function render(array $data, string $locale = 'bn'): string
    {
        $body = $locale === 'en' ? ($this->body_en ?? $this->body_bn) : $this->body_bn;

        foreach ($data as $k => $v) {
            $body = str_replace('{' . $k . '}', (string) $v, $body);
        }

        return $body;
    }
}