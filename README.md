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

To start the built-in dev server, run

    composer start

## Docker stack

To run the server inside docker, run

    docker-compose up -d

## PHPStan - PHP Static analysis

[PHPStan](https://github.com/phpstan/phpstan) is a static code analysis tool.  It is already set up in the repo, to run the report use

    composer phpstan

## PHP Code Sniffer

Uses the [SalesChamp](https://github.com/SalesChamp/codesniffer-ruleset) ruleset.

Usage:

    composer phpcs
