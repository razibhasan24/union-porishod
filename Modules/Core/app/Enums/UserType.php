<?php

namespace Modules\Core\Enums;

enum UserType: string
{
    case SUPER_ADMIN = 'super_admin';
    case CHAIRMAN = 'chairman';
    case SECRETARY = 'secretary';
    case WARD_MEMBER = 'ward_member';
    case FEMALE_MEMBER = 'female_member';
    case ACCOUNTANT = 'accountant';
    case CERTIFICATE_OFFICER = 'certificate_officer';
    case OFFICE_STAFF = 'office_staff';
    case APPLICANT = 'applicant';

    public function labelBn(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'সুপার অ্যাডমিন',
            self::CHAIRMAN => 'চেয়ারম্যান',
            self::SECRETARY => 'সেক্রেটারি',
            self::WARD_MEMBER => 'ওয়ার্ড সদস্য',
            self::FEMALE_MEMBER => 'সংরক্ষিত মহিলা সদস্য',
            self::ACCOUNTANT => 'হিসাবরক্ষক',
            self::CERTIFICATE_OFFICER => 'সার্টিফিকেট অফিসার',
            self::OFFICE_STAFF => 'অফিস স্টাফ',
            self::APPLICANT => 'আবেদনকারী',
        };
    }

    public function labelEn(): string
    {
        return match($this) {
            self::SUPER_ADMIN => 'Super Admin',
            self::CHAIRMAN => 'Chairman',
            self::SECRETARY => 'Secretary',
            self::WARD_MEMBER => 'Ward Member',
            self::FEMALE_MEMBER => 'Female Member',
            self::ACCOUNTANT => 'Accountant',
            self::CERTIFICATE_OFFICER => 'Certificate Officer',
            self::OFFICE_STAFF => 'Office Staff',
            self::APPLICANT => 'Applicant',
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

    public static function adminTypes(): array
    {
        return [
            self::SUPER_ADMIN->value,
            self::CHAIRMAN->value,
            self::SECRETARY->value,
            self::WARD_MEMBER->value,
            self::FEMALE_MEMBER->value,
            self::ACCOUNTANT->value,
            self::CERTIFICATE_OFFICER->value,
            self::OFFICE_STAFF->value,
        ];
    }
}