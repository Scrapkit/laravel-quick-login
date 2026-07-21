<?php

use Scrapkit\QuickLogin\QuickLogin;

it('returns no roles when the roles table does not exist', function () {
    expect(QuickLogin::roles())->toBe([]);
});
