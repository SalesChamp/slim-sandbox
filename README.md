# slim-sandbox

Sandbox project with a reasonable [Slim3](https://www.slimframework.com/) setup.

# Layout

## Config

Config is stored in the `./config` directory.

General config is loaded from `config.neon`.  Local settings can be placed in `local.neon`.  The corresponding trees are then recursively merged.  The config is available in the slim app's container under `settings` key, so

``` php
$settings = $container->get('settings');
```

## Logs

Logs go to `stdout` if run from docker, otherwise they are stored in the `./logs` directory.

## Public

The starting point of the application is `./public/index.php` file.  For a simple REST application with no UI nothing else is usually necessary to be added to the `./public` directory.

## Src

Holds the actual logic of the application.

The `bootstrap.php` file should be `require_once` from the "starting point" of the application (`./public/index.php`), it returns a configured `Slim\App` instance.

Configure your routes in `Router.php` method `registerRoutes`.  It is adviced to use "controller callback" syntax, that is `class:method`, see the example.

Dependency Injection Container is configured in `Configurator` method `configureContainer`.  A good convention for naming of the services is to use the full qualified names of the classes, using the PHP `::class` operator.

## Tests

Tests for the application are stored here.  Additional configuration for dev tools is also stored here.

# Dev tools

## Dev server

To start the built-in dev server on port `8080`, run

    composer start

If you have `docker-compose` available, it is adviced to use the provided docker stack.

## Docker stack

To run the stack with docker, run

    docker-compose up -d

This boots the application itself running under `php-fpm` on port 9000 (internally) and an `nginx` front-end listening on `8080`.

## Nette Tester

[Nette Tester](https://github.com/nette/tester/) is a lightweight alternative to [PHPUnit](https://phpunit.de/).

Place your tests under `./tests/` followed by PSR-4 compatible directory structure, so a class `App\Controllers\Hello` goes into `./tests/App/Controllers/Hello.phpt`.

Remember to `require_once __DIR__ .'/../bootstrap.php'` (add appropriate number of `../` to point to `./tests/bootstrap.php`) to enable autoloading of your classes.

Tests should be under `Tests\` namespace followed by the namespace of the class being tested, so the test class `App\Controllers\HelloTest` goes under `Tests\App\Controllers` namespace.

Run

    composer tester

to run the testsuite.

If you need additional extensions to load during tests, add them to `./tests/php.ini` (`json` is included by default).

## PHPStan - PHP Static analysis

[PHPStan](https://github.com/phpstan/phpstan) is a static code analysis tool.  It is already set up in the repo, to run the report use

    composer phpstan

## PHP Code Sniffer

Uses the [SalesChamp](https://github.com/SalesChamp/codesniffer-ruleset) ruleset.

Usage:

    composer phpcs
