<?php

use Inertia\Inertia;

it('lazily shares the quick login roles with inertia', function () {
    createRole('admin');

    $shared = Inertia::getShared('quickLogin');

    expect($shared)->toBeInstanceOf(Closure::class)
        ->and(value($shared))->toBe([
            'roles' => [
                [
                    'name' => 'admin',
                    'url' => route('quick-login.store', ['role' => 'admin']),
                ],
            ],
        ]);
});
