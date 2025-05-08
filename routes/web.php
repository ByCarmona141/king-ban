<?php

use Illuminate\Support\Facades\Route;
use ByCarmona141\KingBan\Http\Controllers\KingBanController;

Route::get('/ban', [KingBanController::class, 'index'])->name('ban.index');
