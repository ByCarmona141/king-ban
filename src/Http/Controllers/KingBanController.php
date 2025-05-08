<?php

namespace ByCarmona141\KingBan\Http\Controllers;

use Illuminate\Routing\Controller;
use ByCarmona141\KingBan\Facades\KingBan;

class KingBanController extends Controller {
    public function index() {
        return response()->json(['status' => 'Baneado'], 403);
    }
}