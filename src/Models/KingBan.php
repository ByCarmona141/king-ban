<?php
namespace ByCarmona141\KingBan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KingBan extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'king_user_id',
        'endpoint',
        'token',
        'ip',
        'reason',
        'banned_at',
        'expired_at',
        'active',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'king_user_id' => 'integer',
    ];

    public function banUser($kingUserId) {

    }

    public function banIP($kingUserId) {

    }

    public function banToken($kingUserId) {

    }
}