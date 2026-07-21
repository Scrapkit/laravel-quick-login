<?php

namespace Scrapkit\QuickLogin\Tests\TestSupport;

use Scrapkit\QuickLogin\Tests\TestCase;

class NoMigrationsTestCase extends TestCase
{
    protected function defineDatabaseMigrations(): void
    {
        // No tables at all: the package must survive an unmigrated app.
    }
}
