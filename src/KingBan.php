<?php

namespace ByCarmona141\KingBan;

use ByCarmona141\KingBan\Models\KingBan as KingBanModel;

class KingBan {
    /****************************************************************** BANEOS ******************************************************************/
    public function banUser($kingUserId, $reason = NULL, $endpoint = NULL, $token = NULL, $ip = NULL) {
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

    public function banIP($ip, $reason = NULL, $kingUserId = NULL, $endpoint = NULL, $token = NULL) {
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

    public function banToken($token, $reason = NULL, $kingUserId = NULL, $endpoint = NULL, $ip = NULL) {
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

    public function permanentBanUser($kingUserId, $reason = NULL, $endpoint = NULL, $token = NULL, $ip = NULL) {
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

    public function permanentBanIP($ip, $reason = NULL, $kingUserId = NULL, $endpoint = NULL, $token = NULL) {
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

    public function permanentBanToken($token, $reason = NULL, $kingUserId = NULL, $endpoint = NULL, $ip = NULL) {
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

    public function unbanUser($kingUserId) {
        return KingBanModel::where('type', 'user')
            ->where('king_user_id', $kingUserId)
            ->where('active', true)
            ->update(['active' => false]);
    }

    public function unbanIP($ip) {
        return KingBanModel::where('type', 'ip')
            ->where('ip', $ip)
            ->where('active', true)
            ->update(['active' => false]);
    }

    public function unbanToken($token) {
        return KingBanModel::where('type', 'token')
            ->where('token', $token)
            ->where('active', true)
            ->update(['active' => false]);
    }

    /****************************************************************** HELPERS ******************************************************************/
    public function isUserBanned($kingUserId): bool {
        return KingBanModel::where('type', 'user')
            ->where('king_user_id', $kingUserId)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->exists();
    }

    public function isIPBanned($ip): bool {
        return KingBanModel::where('type', 'ip')
            ->where('ip', $ip)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->exists();
    }

    public function isTokenBanned($token): bool {
        return KingBanModel::where('type', 'token')
            ->where('token', $token)
            ->where('active', true)
            ->where(function ($q) {
                $q->whereNull('expired_at')->orWhere('expired_at', '>', now());
            })
            ->exists();
    }

    public function isUserNotBanned($kingUserId): bool {
        return !$this->isUserBanned($kingUserId);
    }

    public function isIpNotBanned($ip): bool {
        return !$this->isIpBanned($ip);
    }

    public function isTokenNotBanned($token): bool {
        return !$this->isTokenBanned($token);
    }
}