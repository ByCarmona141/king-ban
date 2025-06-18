<?php

namespace ByCarmona141\KingBan;

use ByCarmona141\KingBan\Models\KingBan as KingBanModel;

class KingBan {
    /****************************************************************** BANEOS ******************************************************************/
    public function banUser(int $kingUserId, string $reason = NULL, string $endpoint = NULL, string $token = NULL, string $ip = NULL) {
        return KingBanModel::create([
            'type' => 'user',
            'king_user_id' => $kingUserId,
            'endpoint' => ($endpoint === NULL) ? request()->path() : $endpoint,
            'token' => ($token === NULL) ? request()->bearerToken() : $token,
            'ip' => ($ip === NULL) ? request()->ip() : $ip,
            'reason' => ($reason === NULL) ? 'Banned by KingBan' : $reason,
            'banned_at' => now(),
            'expired_at' => now()->addSeconds(config('king-ban.banned.seconds')),
            'active' => true,
        ]);
    }

    public function banIP(string $ip, string $reason = NULL, int $kingUserId = NULL, string $endpoint = NULL, string $token = NULL) {
        return KingBanModel::create([
            'type' => 'ip',
            'king_user_id' => ($kingUserId === NULL) ? NULL : $kingUserId,
            'endpoint' => ($endpoint === NULL) ? request()->path() : $endpoint,
            'token' => ($token === NULL) ? request()->bearerToken() : $token,
            'ip' => $ip,
            'reason' => ($reason === NULL) ? 'Banned by KingBan' : $reason,
            'banned_at' => now(),
            'expired_at' => now()->addSeconds(config('king-ban.banned.seconds')),
            'active' => true,
        ]);
    }

    public function banToken(string $token, string $reason = NULL, int $kingUserId = NULL, string $endpoint = NULL, string $ip = NULL) {
        return KingBanModel::create([
            'type' => 'token',
            'king_user_id' => ($kingUserId === NULL) ? NULL : $kingUserId,
            'endpoint' => ($endpoint === NULL) ? request()->path() : $endpoint,
            'token' => $token,
            'ip' => ($ip === NULL) ? request()->ip() : $ip,
            'reason' => ($reason === NULL) ? 'Banned by KingBan' : $reason,
            'banned_at' => now(),
            'expired_at' => now()->addSeconds(config('king-ban.banned.seconds')),
            'active' => true,
        ]);
    }

    public function permanentBanUser(int $kingUserId, string $reason = NULL, string $endpoint = NULL, string $token = NULL, string $ip = NULL) {
        return KingBanModel::create([
            'type' => 'user',
            'king_user_id' => $kingUserId,
            'endpoint' => ($endpoint === NULL) ? request()->path() : $endpoint,
            'token' => ($token === NULL) ? request()->bearerToken() : $token,
            'ip' => ($ip === NULL) ? request()->ip() : $ip,
            'reason' => ($reason === NULL) ? 'Banned by KingBan' : $reason,
            'banned_at' => now(),
            'expired_at' => NULL,
            'active' => true,
        ]);
    }

    public function permanentBanIP(string $ip, string $reason = NULL, int $kingUserId = NULL, string $endpoint = NULL, string $token = NULL) {
        return KingBanModel::create([
            'type' => 'ip',
            'king_user_id' => ($kingUserId === NULL) ? NULL : $kingUserId,
            'endpoint' => ($endpoint === NULL) ? request()->path() : $endpoint,
            'token' => ($token === NULL) ? request()->bearerToken() : $token,
            'ip' => $ip,
            'reason' => ($reason === NULL) ? 'Banned by KingBan' : $reason,
            'banned_at' => now(),
            'expired_at' => NULL,
            'active' => true,
        ]);
    }

    public function permanentBanToken(string $token, string $reason = NULL, int $kingUserId = NULL, string $endpoint = NULL, string $ip = NULL) {
        return KingBanModel::create([
            'type' => 'token',
            'king_user_id' => ($kingUserId === NULL) ? NULL : $kingUserId,
            'endpoint' => ($endpoint === NULL) ? request()->path() : $endpoint,
            'token' => $token,
            'ip' => ($ip === NULL) ? request()->ip() : $ip,
            'reason' => ($reason === NULL) ? 'Banned by KingBan' : $reason,
            'banned_at' => now(),
            'expired_at' => NULL,
            'active' => true,
        ]);
    }

    /****************************************************************** DESBANEOS ******************************************************************/

    public function unbanUser(int $kingUserId) {
        return KingBanModel::where('type', 'user')
            ->where('king_user_id', $kingUserId)
            ->where('active', true)
            ->update(['active' => false]);
    }

    public function unbanIP(string $ip) {
        return KingBanModel::where('type', 'ip')
            ->where('ip', $ip)
            ->where('active', true)
            ->update(['active' => false]);
    }

    public function unbanToken(string $token) {
        return KingBanModel::where('type', 'token')
            ->where('token', $token)
            ->where('active', true)
            ->update(['active' => false]);
    }

    /****************************************************************** HELPERS ******************************************************************/
    public function isUserBanned(int $kingUserId): bool {
        return KingBanModel::where('type', 'user')
            ->where('king_user_id', $kingUserId)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->exists();
    }

    public function isIPBanned(string $ip): bool {
        return KingBanModel::where('type', 'ip')
            ->where('ip', $ip)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->exists();
    }

    public function isTokenBanned(string $token): bool {
        return KingBanModel::where('type', 'token')
            ->where('token', $token)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->exists();
    }

    public function isBanned(string $type, string|int $value): bool {
        return KingBanModel::where('type', $type)
            ->where(function ($q) use ($type, $value) {
                if ($type === 'ip') {
                    $q->where('ip', $value);
                } elseif ($type === 'token') {
                    $q->where('token', $value);
                } elseif ($type === 'user') {
                    $q->where('king_user_id', $value);
                }
            })
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->exists();
    }

    public function isUserNotBanned(int $kingUserId): bool {
        return !$this->isUserBanned($kingUserId);
    }

    public function isIpNotBanned(string $ip): bool {
        return !$this->isIpBanned($ip);
    }

    public function isTokenNotBanned(string $token): bool {
        return !$this->isTokenBanned($token);
    }

    public function isNotBanned(string $type, string|int $value): bool {
        return !$this->isBanned($type, $value);
    }

    /****************************************************************** ESTADISTICAS ******************************************************************/
}