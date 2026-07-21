<?php

return [

    /*
     * Force quick login on or off. When null, quick login is enabled
     * automatically in the environments listed below.
     */
    // @phpstan-ignore larastan.noEnvCallsOutsideOfConfig (package config is read from vendor until published into the app's config dir)
    'enabled' => env('QUICK_LOGIN_ENABLED'),

    /*
     * Environments where quick login auto-enables when `enabled` is null.
     */
    'environments' => ['local'],

    /*
     * Auth guard used to log the user in. null = default guard.
     */
    'guard' => null,

    /*
     * User model queried for role members. null = config('auth.providers.users.model').
     */
    'user_model' => null,

    /*
     * Where to redirect after a quick login. null = config('fortify.home') ?? '/'.
     */
    'redirect_to' => null,

    /*
     * Role names that must never appear as quick-login buttons.
     */
    'exclude' => [],

    'route' => [
        'path' => 'quick-login',
        'name' => 'quick-login.store',
        'middleware' => ['web'],
    ],

];
