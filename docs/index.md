## Documentation

### How to Use

All you need to do to use the package is to install it via composer:

```bash
composer require tallstackui/envbar
```

After that, the EnvBar will be injected on your application.

### Configuration File:

- Publishing the config file:

```bash
php artisan vendor:publish --tag=envbar-config
```

### Environment Variables:

Almost all the configuration is done through environment variables. Here are the available environment variables:

1. `ENVBAR_ENABLED`: Enable/disable the package. Default is `true`.
2. `ENVBAR_DISABLE_ON_TESTS` - Enable/disable the package on tests. Default is `true`.
3. `ENVBAR_SIZE` - Set the size of the bar. Allowed: xs, sm, md, lg, xl. Default is `md`.
4. `ENVBAR_FIXED` - If the bar should be fixed at the top. Default is `true`.
5. `ENVBAR_TAILWIND_BREAKING_POINTS` - If the TailwindCSS breakpoints should be displayed.
6. `ENVBAR_WARNING_MESSAGE` - Allows you to set a warning message.
7. `ENVBAR_CLOSABLE_ENABLED` - If the close button should be displayed. Default is `true`.
8. `ENVBAR_CLOSABLE_TIMEOUT` - If after closing the bar, it should be displayed again after a certain time, in minutes. Default is `null`.
9. `ENVBAR_FOR_AUTHENTICATED_USERS_ENABLED` - If the bar should be displayed only for authenticated users. Default is `false`. Requires a Gate to be defined with `envbar::view` ability, [similar we do with Horizon](https://laravel.com/docs/11.x/horizon#dashboard-authorization), but with `envbar::view` ability.
10. `ENVBAR_FOR_AUTHENTICATED_USERS_GUARD` - The default guard to be used for authenticated users. Default is `web`.
11. `ENVBAR_ON_MOBILE` - If the bar should be displayed on mobile. Default is `false`.
12. `ENVBAR_PROVIDER` - The provider to be used for fetching the last release. Allowed: github, bitbucket, envoyer. Default is `null`.
13. `ENVBAR_GITHUB_TOKEN` - GitHub token to be used for fetching the last release.
14. `ENVBAR_GITHUB_REPOSITORY` - GitHub repository to be used for fetching the last release.
15. `ENVBAR_GITHUB_CACHED_FOR` - The time in days to cache the last release. Default is `1`.
16. `ENVBAR_BITBUCKET_TOKEN` - BitBucket token to be used for fetching the last release.
17. `ENVBAR_BITBUCKET_REPOSITORY` - BitBucket repository to be used for fetching the last release.
18. `ENVBAR_BITBUCKET_CACHED_FOR` - The time in days to cache the last release. Default is `1`. 
19. `ENVBAR_ENVOYER_TOKEN` - Envoyer token to be used for fetching the last release. 
20. `ENVBAR_ENVOYER_PROJECT_ID` - Envoyer project id to be used for fetching the last release. 
21. `ENVBAR_BITBUCKET_CACHED_FOR` - The time in days to cache the last release. Default is `1`. 


### Other Configurations:

In the config file you can configure the environments and the colors for each environment:

```php
'environments' => [
    'local' => 'green',
    'staging' => 'yellow',
    'sandbox' => 'orange',
    // 'production' => 'red',
],
```

- The production environment is not included by default. If you want to include it, you can uncomment the line.
- All the colors are TailwindCSS colors, **except: black and white.**

You can ignore the EnvBar for specific pages:

```php
'ignore_on' => [
    'pulse/*',
    'horizon/*',
    'telescope/*',
],
```
Behind the scenes, this feature uses `Request::is` to check the current route.

### Clear Release Cache:

To avoid multiple requests to the git provider, the latest release is cached. If you want to clear the release cache, you can clear the entire application cache or run the following command to clear the release cache only:

```bash
php artisan envbar:flush-release-cache
```
