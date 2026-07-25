# Changelog

All notable changes to `laravel-quick-login` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.1.0/)
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2026-07-25

First stable release. No code changes from 0.1.0: the public API has been
reviewed and is now frozen. From here on any breaking change requires a MAJOR,
and anything removed is deprecated in a MINOR first.

## [0.1.0] - 2026-07-21

Initial release. Role-based quick login for local environments.

### Added

- `QuickLogin` helper: `enabled()`, `roles()`, `userModel()` and `redirectTo()`,
  which expose the resolved configuration to the host application's UI.
- `QuickLoginController` and the published `quick-login` route
  (`quick-login.store`, `web` middleware), which logs in a representative user
  for the requested role.
- Config file `quick-login.php`: `enabled` (via `QUICK_LOGIN_ENABLED`, auto-on
  in the listed `environments` when null), `guard`, `user_model`, `redirect_to`,
  `exclude` for roles that must never surface as buttons, and the `route` block.

### Security

- Quick login is off outside the configured environments — `local` only by
  default — and must be enabled explicitly anywhere else.
