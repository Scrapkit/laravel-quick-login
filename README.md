# One-click role-based login buttons for local Laravel development

Speed up local development by logging in with one click. For every role defined
in your application (via [spatie/laravel-permission](https://github.com/spatie/laravel-permission)),
the package exposes a button on the login page that authenticates you as the
first user holding that role — no email, no password. Strictly for local
environments: outside the allowed environments the route is never registered.

## Requirements

- PHP 8.3+
- Laravel 12+
- [spatie/laravel-permission](https://github.com/spatie/laravel-permission) v8

## Installation

Install the package as a dev dependency:

```bash
composer require --dev scrapkit/laravel-quick-login
```

Optionally publish the config file:

```bash
php artisan vendor:publish --tag="quick-login-config"
```

This is the contents of the published config file:

```php
return [

    /*
     * Force quick login on or off. When null, quick login is enabled
     * automatically in the environments listed below.
     */
    'enabled' => env('QUICK_LOGIN_ENABLED'),

    /*
     * Environments where quick login auto-enables when `enabled` is null.
     */
    'environments' => ['local'],

    /*
     * Auth guard used to log the user in. null = default guard.
     */
    'guard' => null,

    /*
     * User model queried for role members. null = config('auth.providers.users.model').
     */
    'user_model' => null,

    /*
     * Where to redirect after a quick login. null = config('fortify.home') ?? '/'.
     */
    'redirect_to' => null,

    /*
     * Role names that must never appear as quick-login buttons.
     */
    'exclude' => [],

    'route' => [
        'path' => 'quick-login',
        'name' => 'quick-login.store',
        'middleware' => ['web'],
    ],

];
```

## Usage

When enabled, the package registers `POST /quick-login/{role}` and shares a
`quickLogin` prop with every Inertia page:

```json
{
    "roles": [
        { "name": "superAdmin", "url": "https://app.test/quick-login/superAdmin" },
        { "name": "amministratore", "url": "https://app.test/quick-login/amministratore" }
    ]
}
```

Roles come straight from the database. When the `roles` table has a
`hierarchy_rank` column (see [scrapkit/laravel-permission-hierarchy](https://github.com/Scrapkit/laravel-permission-hierarchy))
buttons are ordered by rank, otherwise by name. Posting to a role's URL logs in
the first user holding that role and redirects to `redirect_to`
(`fortify.home` by default). Unknown roles and roles without users return 404.

### Inertia React component

For Inertia + React applications, publish the ready-made component into your
app:

```bash
php artisan vendor:publish --tag="quick-login-components"
```

This copies `resources/js/components/quick-login.tsx` into your application —
it uses your own `@/components/ui/button` — so you can drop it into the login
page:

```tsx
import QuickLogin from '@/components/quick-login';

// inside your login page, below the form
<QuickLogin />
```

The component renders nothing when the package is disabled or removed, so it
is safe to keep in the page.

### Other stacks

The package backend is frontend-agnostic: any `<form method="POST">` (with CSRF
token) posting to `route('quick-login.store', ['role' => $name])` works.

### Route caching

The route is registered only while quick login is enabled. If you cache routes
locally, refresh the cache (`php artisan route:clear`) after toggling it.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Credits

- [Vincenzo Scozzari](https://github.com/Scoz9)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
