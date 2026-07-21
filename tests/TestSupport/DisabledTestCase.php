<?php

namespace Scrapkit\QuickLogin\Tests\TestSupport;

use Scrapkit\QuickLogin\Tests\TestCase;

class DisabledTestCase extends TestCase
{
    public function getEnvironmentSetUp($app)
    {
        $this->configureBaseEnvironment();

        // `enabled` stays null and "testing" is not among the allowed
        // environments, so the package must stay off.
    }
}
