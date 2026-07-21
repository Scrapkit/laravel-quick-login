<?php

use Illuminate\Support\Facades\Route;
use Scrapkit\QuickLogin\Http\Controllers\QuickLoginController;
use Scrapkit\QuickLogin\QuickLogin;

if (! QuickLogin::enabled()) {
    return;
}

Route::middleware(config('quick-login.route.middleware', ['web']))
    ->post(config('quick-login.route.path', 'quick-login').'/{role}', QuickLoginController::class)
    ->name(config('quick-login.route.name', 'quick-login.store'));
