<?php

use Scrapkit\QuickLogin\QuickLogin;

it('orders roles by hierarchy rank when the column exists', function () {
    createRole('operatore', rank: 2);
    createRole('superAdmin', rank: 0);
    createRole('amministratore', rank: 1);

    expect(array_column(QuickLogin::roles(), 'name'))
        ->toBe(['superAdmin', 'amministratore', 'operatore']);
});
