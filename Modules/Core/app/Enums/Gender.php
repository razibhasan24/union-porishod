<?php

namespace Modules\Core\Enums;

enum Gender: string
{
    case MALE = 'male';
    case FEMALE = 'female';
    case OTHER = 'other';

    public function labelBn(): string
    {
        return match($this) {
            self::MALE => 'পুরুষ',
            self::FEMALE => 'মহিলা',
            self::OTHER => 'অন্যান্য',
        };
    }

    public static function toArray(): array
    {
        $arr = [];
        foreach (self::cases() as $case) {
            $arr[$case->value] = $case->labelBn();
        }
        return $arr;
    }
}