<?php

use Scrapkit\QuickLogin\QuickLogin;

it('returns every role with its login url', function () {
    createRole('admin');

    expect(QuickLogin::roles())->toBe([
        [
            'name' => 'admin',
            'url' => route('quick-login.store', ['role' => 'admin']),
        ],
    ]);
});

it('orders roles by name when no hierarchy column exists', function () {
    createRole('editor');
    createRole('admin');

    expect(array_column(QuickLogin::roles(), 'name'))->toBe(['admin', 'editor']);
});

it('excludes configured roles', function () {
    createRole('admin');
    createRole('ghost');
    config()->set('quick-login.exclude', ['ghost']);

    expect(array_column(QuickLogin::roles(), 'name'))->toBe(['admin']);
});
