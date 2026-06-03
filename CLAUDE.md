# CLAUDE.md

Guidance for Claude Code when working in this repository. This file is self-contained — do not rely on `README.md`.

## Project

`verifiedit/log-notifications` — a Composer package providing a Laravel Service Provider that listens for Laravel notification events and writes them to a log/audit store. Consumed by Verified's Laravel API repos. **This is not a standalone Laravel application/runtime — it’s installed into a host app.**

## Stack

- **Language:** PHP `>=8.2`
- **Package manager:** Composer
- **Framework integration:** Laravel 11 / 12 (`illuminate/events`, `illuminate/notifications`, `illuminate/support`, `illuminate/contracts`, `illuminate/config`)
- **Tests:** Pest 3 (parallel)
- **Static analysis:** PHPStan 2 (`phpstan.neon`)
- **Style:** none configured in `composer.json`
- **PSR-4 namespace:** `Verifiedit\LogNotifications\` → `src/`
- **Auto-discovery:** registers `Verifiedit\LogNotifications\ServiceProvider` via `extra.laravel.providers`.

## Commands

This is a library — there is no app to start. Run tooling directly:

```shell
composer install
composer run tests              # ./vendor/bin/pest --parallel
composer run phpstan            # ./vendor/bin/phpstan analyse --memory-limit 512M
composer run phpstan:github     # phpstan with GitHub Actions error format
```

There is no Pint/CS-fixer script — match the surrounding style.

## Before declaring a task complete

Run, in order: `composer run phpstan`, `composer run tests`. Fix every failure. The CI workflow (`.github/workflows/build.yml`) runs the same checks via `.github/actions/tests` and `.github/actions/standards` — do not bypass these checks.

## Layout

```
src/
  ServiceProvider.php       # Publishes/merges config + registers listeners
  Contracts/                # Interfaces consumed by the listeners
  Listeners/                # Notification event listeners
tests/
  Pest.php, TestCase.php
  Unit/                     # Pest unit tests
config/
  config.php                # Default package config — `application-name` etc.
phpstan.neon
phpunit.xml
composer.json
```

## Conventions

- **Commits** must include the Jira ticket: `[PH-1234] description`.
- **PR reviewers**: `verifiedit/dev`.
- **Public API stability.** This package is consumed by other repos — breaking a contract or listener signature requires a major version bump and coordinated downstream PRs.
- **No app-level concerns.** Resolve services via constructor injection / the container; don't reach for `Facade` shortcuts unless the rest of the file already does.
- **Type everything** — parameter and return types on every public method.
- **Tests are mandatory** for every public method and every listener.
- **Service Provider is the only auto-loaded boundary** — keep it small; push logic into Listeners and Contracts.

## Releasing

- Tag with semver (`vX.Y.Z`). Downstream apps pin via caret/tilde in their `composer.json`.
- Do not push downstream PRs from this repo — bumping consumers is their responsibility.

## Things to avoid

- Adding runtime config that requires app-level secrets — pass them in via the package config or constructor.
- Bumping the PHP minimum (`>=8.2`) without confirming with consumer repos.
- Committing `vendor/`, `.phpunit.result.cache`, or `.phpunit.cache/`.
- Pulling in additional `illuminate/*` components without checking they're already required by all consumers.

## Skills

- `/code-review`, `/review`, `/security-review`, `/simplify`, `/init`.
