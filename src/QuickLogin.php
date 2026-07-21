<?php

namespace Scrapkit\QuickLogin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

final class QuickLogin
{
    public static function enabled(): bool
    {
        $enabled = config('quick-login.enabled');

        if ($enabled !== null) {
            return filter_var($enabled, FILTER_VALIDATE_BOOL);
        }

        return app()->environment(config('quick-login.environments', ['local']));
    }

    /**
     * @return list<array{name: string, url: string}>
     */
    public static function roles(): array
    {
        /** @var class-string<Model> $roleModel */
        $roleModel = config('permission.models.role');
        $table = (new $roleModel)->getTable();

        if (! Schema::hasTable($table)) {
            return [];
        }

        $query = $roleModel::query()->whereNotIn('name', config('quick-login.exclude', []));

        $rankColumn = config('permission-hierarchy.column', 'hierarchy_rank');

        if (Schema::hasColumn($table, $rankColumn)) {
            $query->orderBy($rankColumn);
        }

        return $query->orderBy('name')
            ->pluck('name')
            ->map(fn (string $name): array => [
                'name' => $name,
                'url' => route(config('quick-login.route.name', 'quick-login.store'), ['role' => $name]),
            ])
            ->all();
    }

    /**
     * @return class-string<Model>
     */
    public static function userModel(): string
    {
        return config('quick-login.user_model') ?? config('auth.providers.users.model');
    }

    public static function redirectTo(): string
    {
        return config('quick-login.redirect_to') ?? config('fortify.home') ?? '/';
    }
}
