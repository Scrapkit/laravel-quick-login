<?php

use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    createRole('admin');
});

it('logs in the first user with the role and redirects to the default location', function () {
    $first = createUser();
    $second = createUser();
    $second->assignRole('admin');
    $first->assignRole('admin');

    $this->post('/quick-login/admin')->assertRedirect('/');

    expect(auth()->check())->toBeTrue()
        ->and(auth()->id())->toBe($first->id);
});

it('redirects to the configured redirect_to', function () {
    config()->set('quick-login.redirect_to', '/dashboard');
    createUser()->assignRole('admin');

    $this->post('/quick-login/admin')->assertRedirect('/dashboard');
});

it('falls back to the fortify home when configured', function () {
    config()->set('fortify.home', '/home');
    createUser()->assignRole('admin');

    $this->post('/quick-login/admin')->assertRedirect('/home');
});

it('regenerates the session on login', function () {
    createUser()->assignRole('admin');

    $this->startSession();
    $originalId = session()->getId();

    $this->post('/quick-login/admin');

    expect(session()->getId())->not->toBe($originalId);
});

it('logs in with the configured guard', function () {
    config()->set('auth.guards.quick', ['driver' => 'session', 'provider' => 'users']);
    config()->set('quick-login.guard', 'quick');
    createUser()->assignRole('admin');

    $this->post('/quick-login/admin');

    expect(Auth::guard('quick')->check())->toBeTrue()
        ->and(Auth::guard('web')->check())->toBeFalse();
});

it('returns 404 for a role that does not exist', function () {
    $this->post('/quick-login/ghost')->assertNotFound();
});

it('returns 404 when no user has the role', function () {
    $this->post('/quick-login/admin')->assertNotFound();
});

it('returns 404 when quick login is disabled at runtime after boot', function () {
    createUser()->assignRole('admin');
    config()->set('quick-login.enabled', false);

    $this->post('/quick-login/admin')->assertNotFound();

    expect(auth()->check())->toBeFalse();
});

it('switches user when already authenticated', function () {
    createRole('editor');
    $admin = createUser();
    $admin->assignRole('admin');
    $editor = createUser();
    $editor->assignRole('editor');

    $this->actingAs($admin)->post('/quick-login/editor');

    expect(auth()->id())->toBe($editor->id);
});
