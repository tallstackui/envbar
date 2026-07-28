# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## What This Is

`tallstackui/envbar` is a **standalone Laravel package** (not an application) — a first-party TallStackUI package that injects an environment bar into the top (or bottom) of every HTML response. It is auto-discovered via `extra.laravel.providers` in `composer.json`.

- PSR-4: `TallStackUi\EnvBar\` → `src/`
- Development branch: `2.x` (Laravel 11/12/13, PHP `^8.2`). `1.x` is the previous line (Laravel 10/11/12, PHP `^8.1`); CI runs on push/PR to either.
- Supports Laravel `^11|^12|^13`, PHP `^8.2` (CI matrix: PHP 8.2/8.3/8.4 × Laravel 11/12/13, excluding 8.2 × 13 since Laravel 13 requires `^8.3`)
- User-facing docs live at <https://tallstackui.com/docs/v3/helpers/env-bar>; issues/PRs belong to this repo, not the main TallStackUI repo.

## Commands

```bash
# PHP
composer test            # ./vendor/bin/pest --filter Structure --parallel
composer test:browser    # ./vendor/bin/pest --filter Browser  (needs Chrome + built assets)
composer type            # pest --type-coverage --min=100
composer format          # pint (write)
composer analyse         # phpstan level 6 on src/
composer rector          # rector --dry-run
composer ci:analyse      # type + pint --test + rector --dry-run + phpstan
composer ci              # ci:analyse + Structure + npm run build + Browser

# Single test / single file
./vendor/bin/pest --filter "is_visible"
./vendor/bin/pest tests/Structure/Providers/GitHubProviderTest.php

# Assets
npm run build            # vite build → public/build/{app.css,app.js,manifest.json}
npm run dev
```

Test suites are selected by **`--filter Structure` / `--filter Browser`** (matching the directory name), not by `--testsuite`. Browser tests need `vendor/bin/dusk-updater detect --auto-update` once; set `CI=true` to run headless (`Options::withoutUI()`).

## Critical: Built Assets Are Committed

`public/build/app.css` and `public/build/app.js` are **tracked in git** and read at runtime by `Render::asset()`, then inlined as `<style>`/`<script>` tags into `<head>`. There is no Vite manifest resolution at runtime — `manifest.json` is built but never read.

**Any change to `resources/css/` or `resources/js/` requires `npm run build` and committing `public/build/`** — otherwise the change is invisible to consumers and browser tests still run the stale bundle. Same applies to Tailwind class changes in `src/` or `resources/views/` (see below).

Reads are memoized in a `static` array for the process lifetime, and a missing build degrades to an empty string plus a `report()`ed `RuntimeException` rather than taking the page down.

## Architecture: The Injection Pipeline

The whole package is one HTML string-rewrite pass appended to the `web` middleware group:

1. **`EnvBarServiceProvider::registerMiddleware()`** — `appendMiddlewareToGroup('web', Injection::class)`. No route registration, no publishing needed for the bar to appear.
2. **`Middleware\Injection`** — runs the response, bails if `PreventInjection::aborted()` or `! $response->isSuccessful()`, otherwise hands off to `Render::handle()`.
3. **`Response\PreventInjection`** — the single gatekeeper. Returns `true` (abort) for: disabled config, running unit tests (`disable_on_tests`), route match against `ignore_on` (`Request::routeIs`), failed `envbar::view` Gate when `for_authenticated_users.enabled`, current env not a key of `envbar.environments` (the literal string `'*'` allows all; a malformed value aborts), or mobile UA when `on_mobile` is false.
4. **`Response\Render`** — builds the view via `EnvBarComponentCompiler`, pulls the one-shot `envbar::show` cache flag, resolves the CSP nonce, delegates to `ResponseHandle`.
5. **`Response\ResponseHandle`** — bails unless `Content-Type` contains `text/html`; injects CSS then JS right after the opening `<head>` tag; then, if the body contains the literal string `@envbar`, replaces it with the rendered component, **else** injects the component immediately after the opening `<body>` tag (first match only).

Both tag lookups share the `ResponseHandle::TAG` pattern (case-insensitive, tolerates attributes holding quoted angle brackets) via `sprintf`.

The `@envbar` placeholder is a plain string replacement in the final HTML, **not a Blade directive** — it works because the response is already compiled by the time the middleware runs. The `text/html` guard is what keeps a JSON payload containing the literal `@envbar` from being rewritten.

### Component Compiler Convention

`Compilers\EnvBarComponentCompiler::__invoke()` walks a fixed list of config keys (`size`, `fixed`, `links`, `bottom`, `closable`, `warning_message`, `tailwind_breaking_points`). **If a private method with the same name as the config key exists on the compiler, it is called instead of reading the config directly** — that's the mutation hook (e.g. `links()` parses the `Label|url` comma format, `tailwind_breaking_points()` also requires `tailwind.config.js` to exist in `base_path()`).

To add a config key that needs transformation: add it to the array *and* add a private method of the same name. Note `arch()` tests assert the compiler's method list — adding a method means updating `tests/Structure/Compilers/EnvBarComponentCompilerTest.php`.

`release()` wraps the provider fetch in `rescue(..., null)` so a broken or misconfigured provider degrades to "no release" instead of throwing through the middleware and 500-ing every page. `label()` resolves the provider's display name through `lang/*/providers.php`, falling back to the raw slug.

### Providers (release lookup)

`Providers\AbstractProvider` + one subclass per source. Each subclass declares `protected array $keys` (required config keys), implements `provider(): string` and `fetch(): ?string`. Config values are read lazily through `configuration(string $key, mixed $default = null)` — there is deliberately no constructor caching the config, so tests and runtime config changes are both honoured.

The shared `release(callable $request, string $key)` helper owns the whole cache dance: `validate()` (throws unless `envbar.provider` matches and every `$keys` entry is filled) → cached release → **negative cache** → HTTP call → store or remember the failure. Success is cached under `envbar::{provider}::release` for `cached_for` days; a failed fetch is remembered under `envbar::{provider}::release::failed` for `provider_failure_cached_for` minutes so a down API is not hit on every page view. `envbar:flush` clears both keys.

`GitProvider` is the odd one out — it reads `.git/HEAD` directly (no config, no cache, no `$keys`) and is always called for the branch name. It is intentionally uncached: caching would make a branch switch invisible during local development, which is the package's primary use case.

**Adding a provider** requires four coordinated edits: the class in `src/Providers/`, a `providers.{name}` block in `config/envbar.php`, a `match` arm in `EnvBarComponentCompiler::release()`, and a label in `lang/*/providers.php` (used both by `validate()`'s exception message and by the bar's own UI).

## Tailwind v4 with `eb:` Prefix

`resources/css/app.css` uses `@import "tailwindcss" prefix(eb);` — every utility is written `eb:flex`, `eb:text-green-700`. **Variants come after the prefix** (`eb:focus:ring-1`); `focus:eb:ring-1` compiles to nothing at all.

Content scanning is declared via `@source "../../src/"` and `@source "../views/"`, which is why `Compilers\Colors::MAP` spells out **full literal class strings** for all 22 Tailwind palettes plus the `primary` fallback. Never refactor those into string concatenation — the classes would be dropped from the build.

`Colors` exposes one method per block (`background()`, `icons()`, `badge()`) resolving against that single map; the `envbar-*` custom palette defined in the `@theme` block backs the `primary` entry, used whenever an environment has no configured color or names an unknown one.

## Blade Components

`resources/views/components/envbar.blade.php` is an **anonymous** view rendered directly by `Render::component()` (hence the compiler class supplying its variables, plus `show` and `nonce`). Only `envbar::badge` is registered as a class-based component, extending `View\Components\BaseComponent`, whose `render()` returns the first-class callable `$this->blade(...)` — follow that shape for new class components.

Icons are anonymous Blade files under `resources/views/components/icons/`.

The inline `<script>` carries the nonce, serializes the configuration exactly once, and binds behaviour with `addEventListener` — no `onclick` attributes and nothing hung on `window`, both of which break under a strict CSP.

## Testing Conventions

- **`tests/Structure/`** (Orchestra Testbench + `WithWorkbench`) mixes Pest `arch()` tests with real behavioural tests. `Tests\TestCase::defineEnvironment()` forces the array cache driver, `envbar.disable_on_tests = false` and `envbar.environments = '*'` so the pipeline actually runs.
  - The `arch()` layer asserts method lists (`toHaveMethods`), invokability, and — importantly — **coupling constraints via `toOnlyBeUsedIn()`**: `Render` may only be used in `Injection` and `ResponseHandle`; `ResponseHandle` only in `Render`; `EnvBarComponentCompiler` only in `Render`; `Colors` only in the compiler and `Badge`. Introducing a new caller of those classes breaks the suite by design; treat it as an architecture decision, not a test to loosen casually. This is also why behavioural tests exercise the pipeline through `$this->get(...)` instead of instantiating `Render` directly.
  - Providers are covered with `Http::fake()` across the cache hit, cache miss, negative-cache and validation paths.
- **`tests/Browser/`** (Orchestra Testbench Dusk) drives a real page. `BrowserTestCase` forces `app.env=testing`, `envbar.disable_on_tests=false`, `envbar.environments='*'`, array cache, and serves `tests/Browser/views/welcome.blade.php` at `/`. Per-test config overrides go through `$this->beforeServingApplication(fn ($app, Repository $config) => ...)`, not `config()->set()`.
- Dusk selectors use the `dusk="..."` attribute (e.g. `@envbar_close_button` on the close button).
- Type coverage is enforced at **100%**.

## Static Analysis

PHPStan runs at level 6 with Larastan over `src/` only, with **no baseline and no `@phpstan-ignore` comments** — keep it that way. `config()` returns `mixed`, so narrow it with `is_string`/`is_array`/casts at the call site rather than annotating types away. Rector targets `src/` and `config/` with the PHP 8.2 set.

Pint uses defaults (no `pint.json`).
