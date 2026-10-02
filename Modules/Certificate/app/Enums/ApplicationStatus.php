<?php

namespace Modules\Certificate\Enums;

enum ApplicationStatus: string
{
    case DRAFT = 'draft';
    case SUBMITTED = 'submitted';
    case PENDING_PAYMENT = 'pending_payment';
    case PAID = 'paid';
    case SENT_TO_WARD = 'sent_to_ward';
    case WARD_VERIFIED = 'ward_verified';
    case WARD_REJECTED = 'ward_rejected';
    case SENT_TO_CHAIRMAN = 'sent_to_chairman';
    case CHAIRMAN_APPROVED = 'chairman_approved';
    case CHAIRMAN_REJECTED = 'chairman_rejected';
    case CHAIRMAN_HOLD = 'chairman_hold';
    case READY_FOR_PRINT = 'ready_for_print';
    case PRINTED = 'printed';
    case DELIVERED = 'delivered';
    case EXPIRED = 'expired';
    case CANCELLED = 'cancelled';

    public function labelBn(): string
    {
        return match($this) {
            self::DRAFT => 'খসড়া',
            self::SUBMITTED => 'জমা দেওয়া',
            self::PENDING_PAYMENT => 'পেমেন্ট বাকি',
            self::PAID => 'পেমেন্ট সম্পন্ন',
            self::SENT_TO_WARD => 'ওয়ার্ড সদস্যের কাছে',
            self::WARD_VERIFIED => 'ওয়ার্ড সদস্য যাচাই করেছেন',
            self::WARD_REJECTED => 'ওয়ার্ড সদস্য বাতিল করেছেন',
            self::SENT_TO_CHAIRMAN => 'চেয়ারম্যানের কাছে',
            self::CHAIRMAN_APPROVED => 'চেয়ারম্যান অনুমোদন করেছেন',
            self::CHAIRMAN_REJECTED => 'চেয়ারম্যান বাতিল করেছেন',
            self::CHAIRMAN_HOLD => 'চেয়ারম্যান স্থগিত করেছেন',
            self::READY_FOR_PRINT => 'প্রিন্টের জন্য প্রস্তুত',
            self::PRINTED => 'প্রিন্ট হয়েছে',
            self::DELIVERED => 'প্রদান করা হয়েছে',
            self::EXPIRED => 'মেয়াদ শেষ',
            self::CANCELLED => 'বাতিল',
        };
    }

    public function color(): string
    {
        return match($this) {
            self::DRAFT => 'secondary',
            self::SUBMITTED, self::PAID => 'info',
            self::PENDING_PAYMENT => 'warning',
            self::SENT_TO_WARD, self::SENT_TO_CHAIRMAN => 'primary',
            self::WARD_VERIFIED => 'info',
            self::CHAIRMAN_APPROVED, self::READY_FOR_PRINT => 'success',
            self::WARD_REJECTED, self::CHAIRMAN_REJECTED, self::CANCELLED => 'danger',
            self::CHAIRMAN_HOLD => 'warning',
            self::PRINTED, self::DELIVERED => 'success',
            self::EXPIRED => 'dark',
        };
    }
}