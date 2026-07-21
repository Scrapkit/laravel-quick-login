<?php

use Scrapkit\QuickLogin\QuickLogin;

it('auto enables when the current environment is allowed', function () {
    expect(QuickLogin::enabled())->toBeTrue();
});

it('registers the route and logs in when the environment matches', function () {
    createRole('admin');
    $user = createUser();
    $user->assignRole('admin');

    $this->post('/quick-login/admin')->assertRedirect('/');

    expect(auth()->id())->toBe($user->id);
});
