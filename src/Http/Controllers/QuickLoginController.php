<?php

namespace Scrapkit\QuickLogin\Http\Controllers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Scrapkit\QuickLogin\QuickLogin;

class QuickLoginController
{
    public function __invoke(Request $request, string $role): RedirectResponse
    {
        abort_unless(QuickLogin::enabled(), 404);

        /** @var class-string<Model> $roleModel */
        $roleModel = config('permission.models.role');

        /*
         * The Role instance is resolved before the user query on purpose:
         * spatie's role() scope throws RoleDoesNotExist for unknown names,
         * which would surface as a 500 instead of this 404.
         */
        $roleInstance = $roleModel::query()->where('name', $role)->first();
        abort_if($roleInstance === null, 404, "Role [{$role}] does not exist.");

        $userModel = QuickLogin::userModel();

        /** @var (Model&Authenticatable)|null $user */
        $user = $userModel::query()
            // @phpstan-ignore method.notFound (role() is spatie's HasRoles scope; the user model is resolved from config)
            ->role($roleInstance)
            ->orderBy((new $userModel)->getKeyName())
            ->first();
        abort_if($user === null, 404, "No user has the [{$role}] role.");

        Auth::guard(config('quick-login.guard'))->login($user);
        $request->session()->regenerate();

        return redirect()->intended(QuickLogin::redirectTo());
    }
}
