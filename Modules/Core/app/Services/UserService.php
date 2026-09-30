<?php

namespace Modules\Core\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $data['password'] = Hash::make($data['password'] ?? 'password');
            $data['name'] = $data['name'] ?? $data['name_bn'] ?? 'User';

            $user = User::create($data);

            if (!empty($data['roles'])) {
                $user->syncRoles($data['roles']);
            }

            return $user;
        });
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }

            $user->update($data);

            if (isset($data['roles'])) {
                $user->syncRoles($data['roles']);
            }

            return $user;
        });
    }

    public function sendOtp(User $user): string
    {
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        // TODO: Send SMS
        return $otp;
    }

    public function verifyOtp(User $user, string $otp): bool
    {
        if ($user->otp !== $otp) return false;
        if ($user->otp_expires_at && $user->otp_expires_at->isPast()) return false;

        $user->update([
            'phone_verified' => true,
            'otp' => null,
            'otp_expires_at' => null,
        ]);

        return true;
    }
}