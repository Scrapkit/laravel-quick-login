<?php

namespace Scrapkit\QuickLogin;

use Inertia\Inertia;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class QuickLoginServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-quick-login')
            ->hasConfigFile()
            ->hasRoute('quick-login');
    }

    public function packageBooted(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                $this->package->basePath('/../resources/stubs/quick-login.tsx') => resource_path('js/components/quick-login.tsx'),
            ], 'quick-login-components');
        }

        if (! QuickLogin::enabled() || ! class_exists(Inertia::class)) {
            return;
        }

        Inertia::share('quickLogin', fn (): array => [
            'roles' => QuickLogin::roles(),
        ]);
    }
}
