<?php

namespace ByCarmona141\KingBan\Facades;

use Illuminate\Support\Facades\Facade;

class KingBan extends Facade {
    protected static function getFacadeAccessor() {
        return 'king-ban';
    }
}