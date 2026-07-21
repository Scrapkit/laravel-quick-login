<?php

namespace Scrapkit\QuickLogin\Tests;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Inertia\ServiceProvider as InertiaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Scrapkit\QuickLogin\QuickLoginServiceProvider;
use Scrapkit\QuickLogin\Tests\TestSupport\User;
use Spatie\Permission\PermissionServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            PermissionServiceProvider::class,
            InertiaServiceProvider::class,
            QuickLoginServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $this->configureBaseEnvironment();

        // The Testbench environment is "testing", not "local": force the
        // package on so feature tests can exercise it.
        config()->set('quick-login.enabled', true);
    }

    protected function configureBaseEnvironment(): void
    {
        config()->set('database.default', 'testing');
        config()->set('app.key', 'base64:'.base64_encode(random_bytes(32)));
        config()->set('auth.providers.users.model', User::class);
    }

    protected function defineDatabaseMigrations(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        (include __DIR__.'/../vendor/spatie/laravel-permission/database/migrations/create_permission_tables.php.stub')->up();
    }
}
