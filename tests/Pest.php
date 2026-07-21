<?php

use Scrapkit\QuickLogin\Tests\TestCase;
use Scrapkit\QuickLogin\Tests\TestSupport\DisabledTestCase;
use Scrapkit\QuickLogin\Tests\TestSupport\EnvironmentEnabledTestCase;
use Scrapkit\QuickLogin\Tests\TestSupport\NoMigrationsTestCase;
use Scrapkit\QuickLogin\Tests\TestSupport\User;
use Scrapkit\QuickLogin\Tests\TestSupport\WithHierarchyTestCase;
use Spatie\Permission\Models\Role;

uses(TestCase::class)->in(
    'ArchTest.php',
    'QuickLoginControllerTest.php',
    'RolesTest.php',
    'SharedPropsTest.php',
);
uses(DisabledTestCase::class)->in('DisabledTest.php');
uses(EnvironmentEnabledTestCase::class)->in('EnvironmentGateTest.php');
uses(WithHierarchyTestCase::class)->in('RolesHierarchyTest.php');
uses(NoMigrationsTestCase::class)->in('RolesNoDatabaseTest.php');

function createUser(array $attributes = []): User
{
    return User::create(array_merge([
        'name' => 'Test User',
        'email' => uniqid().'@example.com',
        'password' => 'password',
    ], $attributes));
}

function createRole(string $name, ?int $rank = null): Role
{
    $role = Role::create(['name' => $name]);

    if ($rank !== null) {
        // forceFill bypasses Eloquent's static guardable-columns cache, which
        // in a multi-app test process may predate the hierarchy_rank column.
        $role->forceFill(['hierarchy_rank' => $rank])->save();
    }

    return $role;
}
