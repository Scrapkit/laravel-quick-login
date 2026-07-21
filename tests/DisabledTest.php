<?php

use Inertia\Inertia;
use Scrapkit\QuickLogin\QuickLogin;

it('does not register the quick login route when disabled', function () {
    createRole('admin');
    createUser()->assignRole('admin');

    $this->post('/quick-login/admin')->assertNotFound();
});

it('does not share quick login data with inertia when disabled', function () {
    expect(Inertia::getShared('quickLogin'))->toBeNull();
});

it('stays disabled when enabled is explicitly false even in an allowed environment', function () {
    config()->set('quick-login.enabled', false);
    config()->set('quick-login.environments', ['testing']);

    expect(QuickLogin::enabled())->toBeFalse();
});

it('treats string config values as booleans', function () {
    config()->set('quick-login.enabled', 'false');
    expect(QuickLogin::enabled())->toBeFalse();

    config()->set('quick-login.enabled', 'true');
    expect(QuickLogin::enabled())->toBeTrue();
});
