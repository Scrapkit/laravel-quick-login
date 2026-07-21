<?php

namespace Scrapkit\QuickLogin\Tests\TestSupport;

use Scrapkit\QuickLogin\Tests\TestCase;

class EnvironmentEnabledTestCase extends TestCase
{
    public function getEnvironmentSetUp($app)
    {
        $this->configureBaseEnvironment();

        // `enabled` stays null: the package must auto-enable because the
        // current environment ("testing") is listed here.
        config()->set('quick-login.environments', ['testing']);
    }
}
